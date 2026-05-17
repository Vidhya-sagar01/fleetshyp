<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\KycDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Exception;


class AdminBankDetailController extends Controller
{
    
    public function index()
    {
        try {
            
            $bankDetails = BankDetail::query()
                ->join('users', 'bank_details.user_id', '=', 'users.id')
                ->leftJoin('company_profiles', 'users.id', '=', 'company_profiles.seller_id')
                ->leftJoin('kyc_details', 'users.id', '=', 'kyc_details.user_id')
                ->select(
                     
                    'bank_details.id',
                    'bank_details.beneficiary_name',
                    'bank_details.account_type',
                    'bank_details.account_number',
                    'bank_details.ifsc_code',
                    'bank_details.cheque_image',
                    'bank_details.status',
                    'bank_details.rejection_reason',
                    'bank_details.verified_at',
                    'bank_details.verified_by',
                    'bank_details.created_at as bank_created_at',
                    'bank_details.updated_at',
                    'users.id as user_id',
                    'users.name as user_name',
                    'users.email as user_email',
                    'users.role',
                    'company_profiles.company_name',
                    'company_profiles.brand_name',
                    'company_profiles.company_code',
                    'company_profiles.has_gst',
                    'company_profiles.logo',
                    'kyc_details.status as kyc_status'
                )
                ->orderBy('bank_details.created_at', 'desc')
                ->paginate(15);

            return view('admin.bank.index', compact('bankDetails'));

        } catch (Throwable $e) {
            Log::error('Error loading bank details list: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to load bank details. Please try again later.');
        }
    }

   
    public function approve($id)
    {
        DB::beginTransaction();

        try {
           
            $bankDetail = BankDetail::findOrFail($id);

          
            $bankDetail->update([
                'status' => 'approved',
                'verified_at' => now(),
                'verified_by' => Auth::id(),
                'rejection_reason' => null,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Bank details approved successfully.');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error approving bank details: ' . $e->getMessage(), [
                'bank_id' => $id,
                'admin_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to approve bank details. ' . $e->getMessage());
        }
    }

   
    public function reject(Request $request, $id)
    {
        DB::beginTransaction();

        try {
          
            $validated = $request->validate([
                'reason' => 'required|string|min:5|max:500'
            ], [
                'reason.required' => 'Please provide a reason for rejection.',
                'reason.min' => 'Rejection reason must be at least 5 characters.',
                'reason.max' => 'Rejection reason cannot exceed 500 characters.'
            ]);

           
            $bankDetail = BankDetail::findOrFail($id);

            
            $bankDetail->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['reason'],
                'verified_at' => null,
                'verified_by' => null,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Bank details rejected successfully.');

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error rejecting bank details: ' . $e->getMessage(), [
                'bank_id' => $id,
                'admin_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to reject bank details. ' . $e->getMessage());
        }
    }


   public function show($id)
{
    try {
        // ✅ CORRECT: Start with ::query() to build the SQL query
        $detail = BankDetail::query() 
            ->join('users', 'bank_details.user_id', '=', 'users.id')
            ->leftJoin('company_profiles', 'users.id', '=', 'company_profiles.seller_id')
            ->leftJoin('kyc_details', 'users.id', '=', 'kyc_details.user_id')
            ->select(
                'bank_details.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.role',
                'users.created_at as user_registered_at',
                'company_profiles.company_name',
                'company_profiles.brand_name',
                'company_profiles.company_code',
                'company_profiles.has_gst',
                'company_profiles.website',
                'company_profiles.customer_care_email',
                'company_profiles.customer_care_mobile',
                'company_profiles.logo',
                'kyc_details.status as kyc_status',
                'kyc_details.pan_number',
                'kyc_details.aadhaar_number',
                'kyc_details.business_type'
            )
            ->where('bank_details.id', $id)
            ->firstOrFail(); // Executes the query and gets single result

        return view('admin.bank.show', compact('detail'));

    } catch (Throwable $e) {
        Log::error('Error viewing bank details: ' . $e->getMessage(), [
            'id' => $id,
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->route('admin.bank.index')
            ->with('error', 'Failed to load bank details.');
    }
}

public function viewCheque($id)
{
    $detail = BankDetail::findOrFail($id);

    if (!$detail->cheque_image ||
        !Storage::disk('private')->exists($detail->cheque_image)) {
        abort(404);
    }

    $file = Storage::disk('private')->get($detail->cheque_image);
    $type = Storage::disk('private')->mimeType($detail->cheque_image);

    return response($file, 200)->header('Content-Type', $type);
}

public function approvedList()
{
    try {
        $bankDetails = BankDetail::query()
            ->join('users', 'bank_details.user_id', '=', 'users.id')
            ->leftJoin('company_profiles', 'users.id', '=', 'company_profiles.seller_id')
            ->select(
                'bank_details.id',
                'bank_details.beneficiary_name',
                'bank_details.account_number',
                'bank_details.ifsc_code',
                'bank_details.verified_at',
                'bank_details.verified_by',
                'users.name as user_name',
                'users.email as user_email',
                'company_profiles.company_name',
                'company_profiles.brand_name',
                'company_profiles.logo'
            )
            ->where('bank_details.status', 'approved') 
            ->orderBy('bank_details.verified_at', 'desc')
            ->paginate(15);

        return view('admin.bank.approvedList', compact('bankDetails'));

    } catch (Throwable $e) {
        Log::error('Error loading approved bank list: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to load approved list.');
    }
}
}