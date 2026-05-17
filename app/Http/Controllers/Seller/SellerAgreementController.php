<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use Illuminate\Http\Request;
use App\Models\AgreementAcceptance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Throwable;

class SellerAgreementController extends Controller
{
    
public function show()
{
    try {

        
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('seller.login');
        }

        $userId = $user->id;

       
        $masterAgreement = Agreement::whereNotNull('file_path')
            ->orderBy('version', 'desc')
            ->first();

        if (!$masterAgreement) {
            return back()->with('error', 'No agreement available.');
        }

       
        $alreadyAccepted = AgreementAcceptance::where([
            'agreement_id' => $masterAgreement->id,
            'user_id'      => $userId
        ])->first();

        
        $history = AgreementAcceptance::with('agreement')
            ->where('user_id', $userId)
            ->latest('accepted_at')
            ->get();

        return view('seller.agreements.index', compact(
            'masterAgreement',
            'alreadyAccepted',
            'history'
        ));

    } catch (\Throwable $e) {

        Log::error('Agreement Show Error: '.$e->getMessage());

        return back()->with('error', 'Unable to load agreement.');
    }
}

public function accept(Request $request)
{
    DB::beginTransaction();

    try {

        // ✅ Validation
        $validated = $request->validate([
            'accept'       => ['required', 'accepted'],
            'version'      => ['required', 'string', 'max:20'],
            'section_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // 📄 Fetch master agreement
        $masterAgreement = Agreement::where('version', $validated['version'])
            ->whereNotNull('file_path')
            ->first();

        if (!$masterAgreement) {
            throw new \Exception('Agreement not found for version ' . $validated['version']);
        }

        // 🚫 Check duplicate acceptance
        $alreadyAccepted = AgreementAcceptance::where([
            'agreement_id' => $masterAgreement->id,
            'user_id'      => $user->id
        ])->exists();

        if ($alreadyAccepted) {
            return response()->json([
                'success' => false,
                'message' => 'You have already accepted this agreement.'
            ], 409);
        }

        // 💾 Insert acceptance record
        AgreementAcceptance::create([
            'agreement_id' => $masterAgreement->id,
            'user_id'      => $user->id,
            'accepted_at'  => now(),
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Agreement signed successfully!'
        ], 201);

    } catch (ValidationException $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);

    } catch (Throwable $e) {

        DB::rollBack();

        Log::error('Agreement Accept Error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Server error occurred.'
        ], 500);
    }
}
}