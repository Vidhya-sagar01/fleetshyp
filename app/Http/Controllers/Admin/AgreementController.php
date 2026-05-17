<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class AgreementController extends Controller
{
   
     public function index()
    {
        try {
           
            $agreements = Agreement::whereNotNull('uploaded_by')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('admin.agreements.index', compact('agreements'));

        } catch (Throwable $e) {
            \Log::error('Admin Agreement Index Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load agreements.');
        }
    }

  
    public function store(Request $request)
    {
         // Start DB transaction for safety
        DB::beginTransaction();

        try {
           
            $validated = $request->validate([
                'section_name' => 'required|string|max:255',
                'version'      => 'required|string|max:50|unique:agreements,version', // Ensure version is unique
                'change_description' => 'required|string|max:1000',
                'agreement_pdf' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            ], [
                'version.unique' => 'This version number already exists. Please use a new version.',
                'agreement_pdf.mimes' => 'Only PDF files are allowed.',
                'agreement_pdf.max' => 'The file size must not exceed 10MB.',
            ]);

           
            $file = $request->file('agreement_pdf');
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9.]/', '_', $file->getClientOriginalName());
            
           
            $filePath = $file->storeAs('agreements', $fileName, 'public');

            if (!$filePath) {
                throw new Exception('Failed to upload file to storage.');
            }

           
            Agreement::create([
                'section_name'       => $validated['section_name'],
                'version'            => $validated['version'],
                'change_description' => $validated['change_description'],
                'file_path'          => $filePath,
                'file_name'          => $fileName,
                'uploaded_by'        => Auth::id(),
                'published_at'       => now(),
                'status'             => 'pending', 
                
            ]);

            DB::commit();

            return redirect()->route('admin.agreements.index')
                ->with('success', "Agreement Version {$validated['version']} published successfully!");

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Agreement Upload Error: ' . $e->getMessage());
            
           
            if (isset($filePath) && Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

public function signedAgreements()
{
    // 1. Get Latest Agreement
    $latestAgreement = DB::table('agreements')
        ->orderByDesc('published_at')
        ->first();

    $agreementId = $latestAgreement->id ?? null;

    // Initialize defaults
    $totalSellers = 0;
    $signedCount = 0;
    $signedUsersList = collect([]); 

    if ($agreementId) {
        // 2. Get Total Sellers Count (Using correct role 'seller_admin')
        $totalSellers = DB::table('users')
            ->where('role', 'seller_admin') 
            ->count();

        // 3. Get Detailed List of Sellers Who Signed
        // Join users AND company_profiles to get full business details
        $signedUsersList = DB::table('agreement_acceptances')
            ->join('users', 'agreement_acceptances.user_id', '=', 'users.id')
            ->leftJoin('company_profiles', 'users.id', '=', 'company_profiles.seller_id') // Link user to company
            ->where('agreement_acceptances.agreement_id', $agreementId)
            ->where('users.role', 'seller_admin') // Corrected Role
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'company_profiles.company_name',
                'company_profiles.brand_name',
                'company_profiles.has_gst',
                'company_profiles.company_code',
                'agreement_acceptances.created_at as signed_at',
                'agreement_acceptances.ip_address'
            )
            ->orderBy('agreement_acceptances.created_at', 'desc')
            ->get();

        $signedCount = $signedUsersList->count();
    }

    $notSignedCount = max(0, $totalSellers - $signedCount);
    $percentage = $totalSellers > 0 ? round(($signedCount / $totalSellers) * 100, 2) : 0;

    return view('admin.agreements.signedAgreement', compact(
        'latestAgreement',
        'totalSellers',
        'signedCount',
        'notSignedCount',
        'percentage',
        'signedUsersList'
    ));
}



     public function download($id)
    {
        try {
            $agreement = Agreement::findOrFail($id);

            if (!$agreement->file_path || !Storage::disk('public')->exists($agreement->file_path)) {
                return redirect()->back()->with('error', 'File not found on server.');
            }

            return Storage::disk('public')->download($agreement->file_path, $agreement->file_name);

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Agreement not found.');
        } catch (Throwable $e) {
            \Log::error('Agreement Download Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to download file.');
        }
    }
}