<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FshipService; // Service ko import karein
use Illuminate\Support\Facades\Log;

class StatusController extends Controller
{
    protected $fshipService;

    // Service ko constructer ke zariye inject karein
    public function __construct(FshipService $fshipService)
    {
        $this->fshipService = $fshipService;
    }

    public function index(Request $request)
    {
        
        $waybill = $request->query('awb');
        //dd($waybill);
        $trackingData = null;
        $latestStatus = null;

        if ($waybill) {
            try {
                // 1. Poori journey ke liye Tracking History API [cite: 270, 280]
                $trackingData = $this->fshipService->getTrackingHistory($waybill);
//dd($trackingData);
                // 2. Latest status aur details ke liye Shipment Summary API [cite: 319, 326]
                $latestStatus = $this->fshipService->getShipmentSummary(['waybill' => $waybill]);
                
            } catch (\Exception $e) {
                Log::error("Fship Tracking Error: " . $e->getMessage());
                return back()->with('error', 'Could not fetch tracking details.');
            }
        }

        // View mein dono data pass karenge
        return view('seller.status.index', [
            'trackingData' => $trackingData,
            'latestStatus' => $latestStatus,
            'waybill' => $waybill
        ]);
    }
}