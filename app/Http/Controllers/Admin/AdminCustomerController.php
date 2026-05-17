<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Models\KycDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminCustomerController extends Controller
{
  public function index(Request $request)
{
    $query = User::query();
    $query->where('role', 'seller_admin');
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }
    
    
    if ($request->filled('status')) {
        if ($request->status === 'active') {
            $query->whereNull('suspended_at');
        } elseif ($request->status === 'suspended') {
            $query->whereNotNull('suspended_at');
        }
    }
    
   
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }
    
    
    $sort = $request->get('sort', 'created_at');
    $direction = $request->get('direction', 'desc');
    $query->orderBy($sort, $direction);
    
    
    $stats = [
        'totalUsers' => User::where('role', 'seller_admin')->count(),
        'activeUsers' => User::where('role', 'seller_admin')->whereNull('suspended_at')->count(),
        'suspendedUsers' => User::where('role', 'seller_admin')->whereNotNull('suspended_at')->count(),
        'totalWallet' => Wallet::whereHas('user', fn($q) => $q->where('role', 'seller_admin'))->sum('balance'),
    ];
    
    $users = $query->with('wallet')->paginate(15)->appends($request->query());
    
    return view('admin.costomer.coustomerList', compact('users', 'stats'));
}
    

      public function show(User $user)
    {
        
        $user->load(['wallet', 'kycDetail', 'companyProfile']);
        
        
        $kyc = $user->kycDetail;
        $companyProfile = $user->companyProfile;
        
        return view('admin.costomer.show', compact('user', 'kyc', 'companyProfile'));
    }


 
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,suspend,delete,export',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);
        
        $userIds = $request->users;
        
        switch ($request->action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['suspended_at' => null]);
                $message = count($userIds) . ' users activated';
                break;
                
            case 'suspend':
                User::whereIn('id', $userIds)->update(['suspended_at' => now()]);
                $message = count($userIds) . ' users suspended';
                break;
                
            case 'delete':
                // Soft delete or hard delete based on your needs
                User::whereIn('id', $userIds)->delete();
                $message = count($userIds) . ' users deleted';
                break;
                
            case 'export':
                return $this->exportUsers($userIds);
                
            default:
                return response()->json(['success' => false, 'message' => 'Invalid action'], 400);
        }
        
        return response()->json(['success' => true, 'message' => $message]);
    }
    


public function updateStatus(Request $request, $user)
{
    $request->validate([
        'status' => 'required|in:active,suspended'
    ]);

    $user = User::findOrFail($user);

    $user->update([
        'suspended_at' => $request->status === 'suspended' ? now() : null
    ]);

   return back()->with('success', 'Status updated successfully');
  }


    private function exportUsers(array $userIds)
    {
        
        return response()->json(['success' => true, 'message' => 'Export started']);
    }
    public function wallet(User $user)
{
    $wallet = $user->wallet;

    return view('admin.wallet.show', compact('user','wallet'));
}


public function getPendingKyc()
{
    // Fetch all PENDING records with user relation
    $pendingKyc = KycDetail::with('user')
        ->where('status', 'PENDING')
        ->orderBy('id', 'desc')
        ->get();
    
    return view('admin.costomer.kycPending', compact('pendingKyc'));
}

}