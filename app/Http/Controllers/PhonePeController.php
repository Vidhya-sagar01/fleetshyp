<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\Wallet;
use App\Models\Wallet_transaction;
use App\Models\WalletRecharge;

use PhonePe\Env;
use PhonePe\payments\v2\standardCheckout\StandardCheckoutClient;
use PhonePe\payments\v2\models\request\builders\StandardCheckoutPayRequestBuilder;

class PhonePeController extends Controller
{
    private function getClient(): StandardCheckoutClient
    {
        $env = strtoupper((string) config('phonepe.env')) === 'PRODUCTION'
            ? Env::PRODUCTION
            : Env::UAT;

        return StandardCheckoutClient::getInstance(
            (string) config('phonepe.client_id'),
            (int)    config('phonepe.client_version'),
            (string) config('phonepe.client_secret'),
            $env
        );
    }

    public function pay(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            $client          = $this->getClient();
            $merchantOrderId = 'PP_' . time() . '_' . Auth::id();
            $amount          = (int) round(((float) $request->amount) * 100);

            // FIX: merchantOrderId khud append karo — PhonePe UAT mein query param nahi bhejta
            $redirectUrl = (string) config('phonepe.redirect_url') . '?merchantOrderId=' . $merchantOrderId;

            WalletRecharge::create([
                'user_id'           => Auth::id(),
                'amount'            => (float) $request->amount,
                'razorpay_order_id' => $merchantOrderId,
                'status'            => WalletRecharge::STATUS_PENDING,
                'payment_method'    => 'phonepe',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            $payRequest = StandardCheckoutPayRequestBuilder::builder()
                ->merchantOrderId($merchantOrderId)
                ->amount($amount)
                ->message('Wallet Recharge')
                ->redirectUrl($redirectUrl)
                ->build();

            $response = $client->pay($payRequest);

            Log::info('PhonePe Pay Response', [
                'merchant_order_id' => $merchantOrderId,
                'phonepe_order_id'  => method_exists($response, 'getOrderId') ? $response->getOrderId() : null,
                'state'             => method_exists($response, 'getState') ? $response->getState() : null,
                'redirect_url'      => method_exists($response, 'getRedirectUrl') ? $response->getRedirectUrl() : null,
            ]);

            $paymentUrl = method_exists($response, 'getRedirectUrl')
                ? $response->getRedirectUrl()
                : null;

            if (!$paymentUrl) {
                Log::error('PhonePe: No redirect URL', ['merchant_order_id' => $merchantOrderId]);
                return back()->with('error', 'PhonePe payment URL nahi mili. Dobara try karein.');
            }

            return redirect($paymentUrl);

        } catch (\Throwable $e) {
            Log::error('PhonePe Pay Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);
            return back()->with('error', 'Payment error: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        try {
            Log::info('PhonePe Callback FULL DEBUG', [
                'all'      => $request->all(),
                'query'    => $request->query(),
                'full_url' => $request->fullUrl(),
                'method'   => $request->method(),
            ]);

            $merchantOrderId = (string) (
                $request->query('merchantOrderId')
                ?? $request->input('merchantOrderId')
                ?? ''
            );

            if (!$merchantOrderId) {
                Log::error('PhonePe Callback: merchantOrderId missing', [
                    'url' => $request->fullUrl(),
                    'all' => $request->all(),
                ]);
                return redirect()->route('seller.dashboard')
                    ->with('error', 'Order ID nahi mila.');
            }

            // Always verify via API
            $client   = $this->getClient();
            $response = $client->getOrderStatus($merchantOrderId);

            $state = method_exists($response, 'getState')
                ? $response->getState()
                : null;

            Log::info('PhonePe Status', [
                'merchant_order_id' => $merchantOrderId,
                'state'             => $state,
            ]);

            if ($state === 'COMPLETED') {

                DB::beginTransaction();

                $recharge = WalletRecharge::where('razorpay_order_id', $merchantOrderId)->first();

                if (!$recharge) {
                    DB::rollBack();
                    return redirect()->route('seller.dashboard')
                        ->with('error', 'Recharge record not found.');
                }

                if ($recharge->status === WalletRecharge::STATUS_SUCCESS) {
                    DB::commit();
                    return redirect()->route('seller.dashboard')
                        ->with('success', 'Payment process complete.');
                }

                $transactionId = method_exists($response, 'getTransactionId')
                    ? $response->getTransactionId()
                    : null;

                $recharge->update([
                    'razorpay_payment_id' => $transactionId,
                    'status'              => WalletRecharge::STATUS_SUCCESS,
                    'payment_method'      => 'phonepe',
                    'processed_at'        => now(),
                ]);

                $wallet = Wallet::where('user_id', $recharge->user_id)
                    ->lockForUpdate()->first();

                if (!$wallet) {
                    $wallet = Wallet::create([
                        'user_id'  => $recharge->user_id,
                        'balance'  => 0,
                        'currency' => 'INR',
                    ]);
                }

                $openingBalance = (float) $wallet->balance;
                $wallet->increment('balance', (float) $recharge->amount);
                $wallet->refresh();
                $closingBalance = (float) $wallet->balance;

                Wallet_transaction::create([
                    'user_id'         => $recharge->user_id,
                    'amount'          => (float) $recharge->amount,
                    'type'            => 'credit',
                    'charge_type'     => 'recharge',
                    'source'          => 'phonepe',
                    'opening_balance' => round($openingBalance, 2),
                    'closing_balance' => round($closingBalance, 2),
                    'remark'          => 'PhonePe Wallet Recharge',
                    'fship_order_id'  => null,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                DB::commit();

                Log::info('Wallet Recharged via PhonePe', [
                    'user_id'         => $recharge->user_id,
                    'amount'          => $recharge->amount,
                    'closing_balance' => $closingBalance,
                ]);

                return redirect()->route('seller.dashboard')
                    ->with('success', 'Wallet recharge successful! Rs.' . number_format((float) $recharge->amount, 2) . ' added.');
            }

            WalletRecharge::where('razorpay_order_id', $merchantOrderId)
                ->where('status', WalletRecharge::STATUS_PENDING)
                ->update([
                    'status'         => WalletRecharge::STATUS_FAILED,
                    'failure_reason' => 'Payment state: ' . ($state ?? 'unknown'),
                ]);

            return redirect()->route('seller.dashboard')
                ->with('error', 'Payment failed. State: ' . ($state ?? 'unknown'));

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('PhonePe Callback Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ]);
            return redirect()->route('seller.dashboard')
                ->with('error', 'Callback error: ' . $e->getMessage());
        }
    }

    public function checkStatus(string $merchantOrderId)
    {
        try {
            $response = $this->getClient()->getOrderStatus($merchantOrderId);

            return response()->json([
                'success'  => true,
                'state'    => method_exists($response, 'getState') ? $response->getState() : null,
                'order_id' => method_exists($response, 'getOrderId') ? $response->getOrderId() : null,
                'amount'   => method_exists($response, 'getAmount') ? $response->getAmount() : null,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}