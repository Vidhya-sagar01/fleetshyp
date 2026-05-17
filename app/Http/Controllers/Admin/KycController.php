<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\KycDetail;

class KycController extends Controller
{

public function show($id)
{
    $kyc = KycDetail::with(['user'])->findOrFail($id);
    
    $stats = [
        'total_pending' => KycDetail::where('status', 'PENDING')->count(),
        'today_pending' => KycDetail::where('status', 'PENDING'),
        'total_verified' => KycDetail::where('status', 'VERIFIED')->count(),
        'total_rejected' => KycDetail::where('status', 'REJECTED')->count(),
    ];
    
    return view('admin.costomer.kycAppreved', compact('kyc', 'stats'));
}



    public function getPendingKyc()
{
   
    $pendingKyc = KycDetail::with('user')
        ->where('status', 'PENDING')
        ->orderBy('id', 'desc')
        ->get();
    
    return view('admin.costomer.kycPending', compact('pendingKyc'));
}


public function approve($id)
{
    $kyc = KycDetail::findOrFail($id);
    
    $kyc->update([
        'status' => 'VERIFIED',
        'verified_at' => now(),
        'admin_remarks' => 'Approved by admin',
        'reviewed_by' => auth()->id(),
    ]);
    
    
    if ($kyc->user) {
        $kyc->user->update([
            'is_verified' => true,
            'kyc_status' => 'VERIFIED',
        ]);
    }
    
    return redirect()->route('kyc.pending')
        ->with('success', ' KYC approved successfully! User can now access all features.');
}


public function reject(Request $request, $id)
{
    $request->validate([
        'rejection_reason' => 'required|string|max:500',
    ]);
    
    $kyc = KycDetail::findOrFail($id);
    
    $kyc->update([
        'status' => 'REJECTED',
        'admin_remarks' => $request->rejection_reason,
        'reviewed_by' => auth()->id(),
        'rejected_at' => now(),
    ]);
    
    
    
    return redirect()->route('kyc.pending')
        ->with('success', ' KYC rejected. User has been notified.');
}



public function approvedIndex(Request $request)
{
    $query = KycDetail::with('user')
        ->where('status', 'VERIFIED')
        ->orderBy('verified_at', 'desc');

    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('user', function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%");
        })
        ->orWhere('pan_number', 'LIKE', "%{$search}%")
        ->orWhere('aadhaar_number', 'LIKE', "%{$search}%");
    }

    
    if ($request->filled('business_type')) {
        $query->where('business_type', $request->business_type);
    }

    
    if ($request->filled('date_range')) {
        switch ($request->date_range) {
            case 'today':
                $query->whereDate('verified_at', today());
                break;
            case 'week':
                $query->whereBetween('verified_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('verified_at', now()->month);
                break;
            case 'year':
                $query->whereYear('verified_at', now()->year);
                break;
        }
    }

    // Per page
    $perPage = $request->get('per_page', 25);

    $approvedKyc = $query->paginate($perPage)->withQueryString();

    // Stats
    $stats = [
        'total_pending' => KycDetail::where('status', 'PENDING')->count(),
        'total_rejected' => KycDetail::where('status', 'REJECTED')->count(),
        'verified_today' => KycDetail::where('status', 'VERIFIED')
            ->whereDate('verified_at', today())->count(),
    ];

    return view('admin.costomer.kycApprovedList', compact('approvedKyc', 'stats'));
}

// Export to CSV
public function export($type = 'verified')
{
    $kycRecords = KycDetail::with('user')
        ->where('status', strtoupper($type))
        ->get();

    $filename = "kyc_{$type}_" . date('Y-m-d') . ".csv";
    
    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=\"$filename\"",
    ];

    $callback = function() use ($kycRecords) {
        $file = fopen('php://output', 'w');
        
        // Headers
        fputcsv($file, [
            'ID', 'User Name', 'Email', 'Phone', 
            'Business Type', 'PAN Number', 'Aadhaar Number',
            'Status', 'Verified At', 'Applied At'
        ]);

        // Data
        foreach ($kycRecords as $kyc) {
            fputcsv($file, [
                $kyc->id,
                $kyc->user->name ?? 'N/A',
                $kyc->user->email ?? 'N/A',
                $kyc->user->phone ?? 'N/A',
                $kyc->business_type,
                $kyc->pan_number,
                $kyc->aadhaar_number,
                $kyc->status,
                $kyc->verified_at?->format('Y-m-d H:i:s'),
                $kyc->created_at->format('Y-m-d H:i:s'),
            ]);
        }
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

// Download all documents as ZIP
public function download($id)
{
    $kyc = KycDetail::findOrFail($id);
    
    $zip = new ZipArchive();
    $filename = "kyc_documents_{$kyc->id}_{$kyc->user->name}.zip";
    $zipPath = storage_path('app/temp/' . $filename);
    
    if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
        return back()->with('error', 'Failed to create ZIP file');
    }

    // Add documents to ZIP
    if ($kyc->pan_card_image && Storage::disk('public')->exists($kyc->pan_card_image)) {
        $zip->addFile(storage_path('app/public/' . $kyc->pan_card_image), 'PAN_Card.pdf');
    }
    if ($kyc->aadhaar_card_image && Storage::disk('public')->exists($kyc->aadhaar_card_image)) {
        $zip->addFile(storage_path('app/public/' . $kyc->aadhaar_card_image), 'Aadhaar_Card.pdf');
    }
    if ($kyc->user_photo && Storage::disk('public')->exists($kyc->user_photo)) {
        $zip->addFile(storage_path('app/public/' . $kyc->user_photo), 'User_Photo.jpg');
    }

    $zip->close();

    return response()->download($zipPath)->deleteFileAfterSend(true);
}



public function rejectedIndex(Request $request)
{
    $query = KycDetail::with('user')
        ->where('status', 'REJECTED')
        ->orderBy('id', 'desc');

    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('user', function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%");
        })
        ->orWhere('pan_number', 'LIKE', "%{$search}%")
        ->orWhere('aadhaar_number', 'LIKE', "%{$search}%");
        
    }

    // Business type filter
    if ($request->filled('business_type')) {
        $query->where('business_type', $request->business_type);
    }

    // Date range filter
    if ($request->filled('date_range')) {
        switch ($request->date_range) {
            case 'today':
                $query->whereDate('rejected_at', today());
                break;
            case 'week':
                $query->whereBetween('rejected_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('rejected_at', now()->month);
                break;
            case 'year':
                $query->whereYear('rejected_at', now()->year);
                break;
        }
    }

    // Per page
    $perPage = $request->get('per_page', 25);

    $rejectedKyc = $query->paginate($perPage)->withQueryString();

    // Stats
    $stats = [
        'total_rejected' => KycDetail::where('status', 'REJECTED')->count(),
        'total_pending' => KycDetail::where('status', 'PENDING')->count(),
        'total_verified' => KycDetail::where('status', 'VERIFIED')->count(),
        'reapproved_count' => KycDetail::where('status', 'VERIFIED'),
            
    ];

    return view('admin.costomer.kycRejectLIst', compact('rejectedKyc', 'stats'));
}

// Re-Approve Rejected KYC
public function reapprove($id)
{
    $kyc = KycDetail::findOrFail($id);
    
    $kyc->update([
        'status' => 'VERIFIED',
        'verified_at' => now(),
        'rejected_at' => null,
        'admin_remarks' => 'Re-approved by admin - ' . now()->format('Y-m-d H:i'),
        'reviewed_by' => auth()->id(),
    ]);
    
   
    if ($kyc->user) {
        $kyc->user->update([
            'is_verified' => true,
            'kyc_status' => 'VERIFIED',
        ]);
    }
    
    
    
    return redirect()->route('kyc.rejected')
        ->with('success', ' KYC re-approved successfully! User access has been restored.');
}

}
