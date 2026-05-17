<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RateCard;
use App\Models\User;
use App\Models\Courier;
use App\Traits\HandlesRateCards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RateCardController extends Controller
{
    use HandlesRateCards;


public function rate()
{
    try {
        $users = User::where('role', 'seller_admin')->get();

        // ✅ Active couriers for dropdown
        $couriers = Courier::where('is_active', 1)->get();

        // ✅ FIXED: Eager load BOTH user AND courier relationships
        $rateCards = RateCard::with(['user', 'courier'])  // ← Added 'courier' here
            ->whereHas('user', fn($q) => $q->where('role', 'seller_admin'))
            ->latest()
            ->paginate(10);

        // Grouping logic (Safe coding)
        $grouped = $rateCards->getCollection()
            ->groupBy('user_id')
            ->map(fn($items) => [
                'user' => $items->first()?->user,
                'cards' => $items
            ]);

        $rateCards->setCollection($grouped);

        return view('admin.retecard.index', compact('rateCards', 'users', 'couriers'));

    } catch (\Exception $e) {
        \Log::error("Rate Card Page Error: " . $e->getMessage());
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}
    /**
     * Store
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rateCardRules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
       // dd($request->all());
        try {
            $data = $this->uploadRateCardFiles($request);

            // ✅ Only required fields allow
            $data = $this->sanitizeData($data);

            RateCard::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Rate Card Created'
            ]);

        } catch (\Exception $e) {
            Log::error('Store Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Database Error'
            ], 500);
        }
    }

    /**
     * Update
     */
    public function update(Request $request, RateCard $rateCard)
    {
        $validator = Validator::make($request->all(), $this->rateCardRules($rateCard->id));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $this->uploadRateCardFiles($request, $rateCard);

            $data = $this->sanitizeData($data);

            $rateCard->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Rate Card Updated'
            ]);

        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Update Failed'
            ], 500);
        }
    }

    /**
     * Clean unwanted fields
     */
    /**
 * Clean unwanted fields (Keep only database columns)
 */
private function sanitizeData($data)
{
    // Hum sirf wahi fields rakhenge jo shipping_rates_mini table mein columns hain
    return collect($data)->only([
        'user_id', 
        'type', 
        'plan_name', 
        'courier_id',  // ✅ Ise yahan add kiya hai taaki delete na ho
        'mode', 
        'mode_icon', 
        'weight_info', 
        'add_weight', 
        'is_active',
        'zone_a_forward', 'zone_a_rto', 'zone_a_add_forward', 'zone_a_add_rto', 'zone_a_cod_charge', 'zone_a_cod_percent',
        'zone_b_forward', 'zone_b_rto', 'zone_b_add_forward', 'zone_b_add_rto', 'zone_b_cod_charge', 'zone_b_cod_percent',
        'zone_c_forward', 'zone_c_rto', 'zone_c_add_forward', 'zone_c_add_rto', 'zone_c_cod_charge', 'zone_c_cod_percent',
        'zone_d_forward', 'zone_d_rto', 'zone_d_add_forward', 'zone_d_add_rto', 'zone_d_cod_charge', 'zone_d_cod_percent',
        'zone_e_forward', 'zone_e_rto', 'zone_e_add_forward', 'zone_e_add_rto', 'zone_e_cod_charge', 'zone_e_cod_percent',
    ])->toArray();
}
    /**
     * Edit
     */
    public function editData(RateCard $rateCard)
    {
        return response()->json([
            'success' => true,
            'data' => $rateCard->load('courier')
        ]);
    }

    /**
     * Delete
     */
    public function destroy(RateCard $rateCard)
    {
        try {
            if ($rateCard->mode_icon && \Storage::disk('public')->exists($rateCard->mode_icon)) {
                \Storage::disk('public')->delete($rateCard->mode_icon);
            }

            $rateCard->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Delete Failed'
            ], 500);
        }
    }

    /**
     * Bulk delete
     */
    public function bulkAction(Request $request)
    {
        try {
            $ids = $request->ids ?? [];

            if (!$ids) {
                return response()->json([
                    'success' => false,
                    'message' => 'No IDs provided'
                ], 400);
            }

            RateCard::whereIn('id', $ids)->get()->each(function ($card) {
                if ($card->mode_icon && \Storage::disk('public')->exists($card->mode_icon)) {
                    \Storage::disk('public')->delete($card->mode_icon);
                }
            });

            RateCard::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bulk delete done'
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Bulk failed'
            ], 500);
        }
    }
}