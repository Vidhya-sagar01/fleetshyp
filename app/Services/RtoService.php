<?php
namespace App\Services;

use App\Models\FshipOrder;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RtoService
{
    public function process($orderId)
    {
        try {
            DB::transaction(function () use ($orderId) {

                Log::info('RTO PROCESS STARTED', [
                    'order_id' => $orderId
                ]);

                $order = FshipOrder::where('id', $orderId)
                    ->lockForUpdate()
                    ->first();

                if (!$order) {
                    Log::warning('RTO: Order not found', ['order_id' => $orderId]);
                    return;
                }

                if ($order->rto_processed == 1) {
                    Log::info('RTO: Order already processed', ['order_id' => $orderId]);
                    return;
                }

                $wallet = Wallet::where('user_id', $order->user_id)
                    ->lockForUpdate()
                    ->first();

                if (!$wallet) {
                    Log::error('RTO: Wallet not found', [
                        'order_id' => $orderId,
                        'user_id' => $order->user_id
                    ]);
                    return;
                }
               $rate = DB::table('shipping_rates_mini')
    ->join('couriers', 'shipping_rates_mini.courier_id', '=', 'couriers.id')
    ->where('shipping_rates_mini.user_id', $order->user_id)
    ->where(function($query) use ($order) {
        // Match either local courier.id OR fship_courier_id
        $query->where('couriers.id', $order->courier_id)
              ->orWhere('couriers.fship_courier_id', $order->courier_id);
    })
    ->where('shipping_rates_mini.is_active', 1)
    ->select('shipping_rates_mini.*')
    ->first();

                if (!$rate) {
                    Log::error('RTO: Shipping rate not found', [
                        'order_id' => $orderId,
                        'user_id' => $order->user_id,
                        'courier_id' => $order->courier_id
                    ]);
                    return;
                }

                $zone = strtolower($order->zone ?: 'c');
                $rtoKey = "zone_{$zone}_rto";
                $codKey = "zone_{$zone}_cod_charge";

               // $rtoCharge = (float) ($rate->$rtoKey ?? 0);
                //$codRefund = (float) ($rate->$codKey ?? 0);

                $baseRtoCharge = (float) ($rate->$rtoKey ?? 0);
$gstRate = 18;

$rtoGst = ($baseRtoCharge * $gstRate) / 100;
$rtoCharge = $baseRtoCharge + $rtoGst;

$codRefund = (float) ($rate->$codKey ?? 0);

               Log::info('RTO: Rate details', [
    'order_id' => $orderId,
    'zone' => $zone,
    'base_rto_charge' => $baseRtoCharge,
    'gst_18_percent' => $rtoGst,
    'total_rto_charge' => $rtoCharge,
    'cod_refund' => $codRefund
]);

                $opening = $wallet->balance;

                // COD refund
                if ((int)$order->payment_mode === 1 && $codRefund > 0) {
                    $wallet->increment('balance', $codRefund);

                    DB::table('wallet_transactions')->insert([
                        'user_id' => $order->user_id,
                        'fship_order_id' => $order->id,
                        'amount' => $codRefund,
                        'type' => 'credit',
                        'charge_type' => 'cod_refund',
                        'opening_balance' => $opening,
                        'closing_balance' => $opening + $codRefund,
                        'remark' => "COD Refund AWB: {$order->waybill}",
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    Log::info('RTO: COD Refund applied', [
                        'order_id' => $orderId,
                        'amount' => $codRefund,
                        'new_balance' => $opening + $codRefund
                    ]);

                    $opening += $codRefund;
                }

                // RTO charge
                if ($rtoCharge > 0) {
                    $wallet->decrement('balance', $rtoCharge);

                    DB::table('wallet_transactions')->insert([
                        'user_id' => $order->user_id,
                        'fship_order_id' => $order->id,
                        'amount' => $rtoCharge,
                        'type' => 'debit',
                        'charge_type' => 'rto',
                        'opening_balance' => $opening,
                        'closing_balance' => $opening - $rtoCharge,
                        'remark' => "RTO Charge + 18% GST AWB: {$order->waybill}",
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    Log::info('RTO: RTO Charge applied', [
                        'order_id' => $orderId,
                        'amount' => $rtoCharge,
                        'new_balance' => $opening - $rtoCharge
                    ]);
                }

                $updated = FshipOrder::where('id', $order->id)->update([
    'rto_processed' => 1,
    'updated_at' => now()
]);

Log::info('RTO FLAG UPDATED', [
    'order_id' => $order->id,
    'updated_rows' => $updated
]);
                             
                             
                             
                             
                             
                             

                Log::info('RTO PROCESS COMPLETED', [
                    'order_id' => $orderId,
                    'final_balance' => $wallet->fresh()->balance ?? 'unknown'
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('RTO Service Exception', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}