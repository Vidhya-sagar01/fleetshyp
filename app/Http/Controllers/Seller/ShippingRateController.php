<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingRateController extends Controller
{
    /**
     * Display shipping rates page
     */
    public function index(Request $request)
    {
        // Sample rate data - Replace with your actual database/API logic
        $rateCards = [
            [
                'zone' => 'Zone A',
                'description' => 'Delhi NCR, Nearby States',
                'forward_rate' => '₹45/kg',
                'rto_rate' => '₹45/kg',
                'cod_charge' => '2.5% or ₹30 (whichever higher)',
                'delivery_time' => '1-2 Days',
                'highlight' => true
            ],
            [
                'zone' => 'Zone B',
                'description' => 'Metro Cities & Major Towns',
                'forward_rate' => '₹55/kg',
                'rto_rate' => '₹55/kg',
                'cod_charge' => '2.5% or ₹30 (whichever higher)',
                'delivery_time' => '2-4 Days',
                'highlight' => false
            ],
            [
                'zone' => 'Zone C',
                'description' => 'Rest of India',
                'forward_rate' => '₹65/kg',
                'rto_rate' => '₹65/kg',
                'cod_charge' => '2.5% or ₹30 (whichever higher)',
                'delivery_time' => '4-7 Days',
                'highlight' => false
            ],
            [
                'zone' => 'Zone D',
                'description' => 'Remote & Hilly Areas',
                'forward_rate' => '₹85/kg',
                'rto_rate' => '₹85/kg',
                'cod_charge' => '3% or ₹40 (whichever higher)',
                'delivery_time' => '5-10 Days',
                'highlight' => false
            ],
        ];

        // Terms & Conditions (From your PDF)
        $termsAndConditions = [
            'Above Shared Commercials are Exclusive GST',
            'Freight Weight is Picked - Volumetric or Dead weight whichever is higher will be charged',
            'RTO charge will be same as Forward',
            'Fixed COD charge or COD % of the order value whichever is higher',
            'Other charges like address correction charges if applicable shall be charged extra',
            'Prohibited item not to be ship, if any penalty will charge to seller',
            'No Claim would be entertained for Glassware, Fragile products',
            'Concealed damages and improper packaging',
            'Any weight dispute due to incorrect weight declaration cannot be claimed',
            'Chargeable weight would be volumetric or actual weight, whichever is higher (L×B×H/5000)',
            'Remittance will be paid twice a week i.e. Tuesday and Friday (excluding Bank Holidays)',
            'Invoice will be adjusted via COD Net off'
        ];

        return view('seller.ratecard.index', compact('rateCards', 'termsAndConditions'));
    }

    /**
     * Download rate card as PDF (Optional)
     */
    public function download(Request $request)
    {
        // Implement PDF generation logic here using dompdf/snappy
        return back()->with('info', 'Rate card download feature coming soon!');
    }
}