<?php

namespace App\Http\Controllers\Seller;
use App\Models\RateCard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerRatecardController extends Controller
{

public function index(Request $request)
{
    try {
        $rawType = $request->query('type', 'mini');
        $type = (strtolower($rawType) === 'mini') ? 'mini' : strtoupper($rawType);

        // ✅ 1. Variable define karein
        $selectedPlan = $request->query('plan_name');

        $query = \App\Models\RateCard::with(['courier'])
            ->where('user_id', auth()->id())
            ->where('type', $type);

        // Plan Filter logic
        if (!empty($selectedPlan)) {
            $query->where('plan_name', $selectedPlan);
        }

        $rateCards = $query->latest()->paginate(10);
        $couriers = \App\Models\Courier::where('is_active', 1)->get();

        // ✅ 2. compact() ke andar 'selectedPlan' zaroor likhein
        return view('seller.ratecard.index', compact('rateCards', 'type', 'couriers', 'selectedPlan'));

    } catch (\Exception $e) {
        \Log::error("Seller RateCard Error: " . $e->getMessage());
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}
}
