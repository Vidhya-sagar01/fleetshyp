<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Throwable;

class BankDetailController extends Controller
{
    // ===============================
    // LIST / CREATE / EDIT PAGE
    // ===============================
    public function index()
    {
        $userId = Auth::id();
        $bankDetail = BankDetail::where('user_id', $userId)->first();

        // Check if we are forcing an edit (redirected from edit() method)
        $isEditMode = session('force_edit_mode', false);
        $editData = session('edit_data', null);

        return view('seller.bank.index', compact('bankDetail', 'isEditMode', 'editData'));
    }

    // ===============================
    // STORE / UPDATE LOGIC
    // ===============================
    public function store(Request $request)
    {
        try {
            $bank = BankDetail::where('user_id', Auth::id())->first();
            $isEdit = $bank && $bank->status !== 'approved';

            // Prevent editing if approved
            if ($bank && $bank->status === 'approved') {
                return back()->with('error', 'Approved bank details cannot be edited. Contact support.');
            }

            // Dynamic Validation: Image required only for new entries
            $rules = [
                'beneficiary_name' => 'required|string|max:255',
                'account_type'     => 'required|in:saving,current',
                'account_number'   => 'required|confirmed|digits_between:9,18',
                'ifsc_code'        => 'required|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
                'cheque_image'     => $isEdit ? 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048' : 'required|image|mimes:jpeg,png,jpg,pdf|max:2048'
            ];

            $validated = $request->validate($rules);

            DB::beginTransaction();

            $path = null;
            if ($request->hasFile('cheque_image')) {
                // Delete old image if exists
                if ($bank && $bank->cheque_image) {
                    \Storage::disk('private')->delete($bank->cheque_image);
                }
                $path = $request->file('cheque_image')->store('bank_cheques', 'private');
            } else {
                // Keep existing image if editing and no new file uploaded
                $path = $bank->cheque_image ?? null;
            }

            BankDetail::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'beneficiary_name' => $validated['beneficiary_name'],
                    'account_type'     => $validated['account_type'],
                    'account_number'   => $validated['account_number'],
                    'ifsc_code'        => strtoupper($validated['ifsc_code']),
                    'cheque_image'     => $path,
                    'status'           => 'pending', // Reset to pending on update
                    'verified_by'      => null,
                    'verified_at'      => null,
                    'rejection_reason' => null
                ]
            );

            DB::commit();

            return redirect()->route('bank-details.create')
                ->with('success', $isEdit ? 'Details updated successfully! Sent for re-verification.' : 'Bank details submitted successfully.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Bank Details Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    // ===============================
    // EDIT ACTION (Prepares the form)
    // ===============================
    public function edit($id)
    {
        $bank = BankDetail::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($bank->status === 'approved') {
            return back()->with('error', 'Verified accounts cannot be edited.');
        }

        // Store data in session and redirect to main page with "force edit" flag
        return redirect()->route('bank-details.create')
            ->with('force_edit_mode', true)
            ->with('edit_data', $bank);
    }

    // ===============================
    // VIEW DOCUMENT (Secure)
    // ===============================
    public function document($id)
    {
        $bank = BankDetail::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$bank->cheque_image || !\Storage::disk('private')->exists($bank->cheque_image)) {
            abort(404);
        }

        return \Storage::disk('private')->response($bank->cheque_image);
    }
}