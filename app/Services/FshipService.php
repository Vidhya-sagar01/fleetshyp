<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FshipService
{

   private function getHeaders()
    {
        return [
            'signature'    => config('fship.signature'),
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json'
        ];
    }
    public function addWarehouse(array $data)
    {
     try {
    
        $response = Http::withHeaders([
            'signature' => config('fship.signature'),
            'Content-Type' => 'application/json'
        ])
        ->withoutVerifying()
        ->post(
            config('fship.base_url') . '/addwarehouse',
            $data
        );

        return $response;
                //code...
     } catch (\Throwable $th) {
        dd($th->getMessage());
     }
    }

    public function updateWarehouse(array $data) {
    return Http::withHeaders([
        'signature' => config('fship.signature'),
        'Content-Type' => 'application/json'
    ])->withoutVerifying()
      ->post(config('fship.base_url') . '/updatewarehouse', $data);
}

public function createForwardOrder(array $data)
    {
        try {
            $response = Http::withHeaders([
                'signature' => config('fship.signature'), 
                'Content-Type' => 'application/json'
            ])
            ->withoutVerifying()
            ->post(config('fship.base_url') . '/createforwardorder', $data);

            return $response->json();
        } catch (\Throwable $th) {
            return ['status' => false, 'response' => $th->getMessage()];
        }
    }

 

public function getAllCouriers()
{
    return Http::withHeaders([
        'signature' => config('fship.signature'),
        'Content-Type' => 'application/json'
    ])->withoutVerifying()->get(config('fship.base_url') . '/getallcourier'); 
}

public function calculateRates(array $data)
{
    // PDF Rule: Volumetric Weight is (LxBxH/5000) 
    $volumetricWeight = ($data['shipment_Length'] * $data['shipment_Width'] * $data['shipment_Height']) / 5000;
    $data['volumetric_Weight'] = $volumetricWeight;

    return Http::withHeaders([
        'signature' => config('fship.signature'),
        'Content-Type' => 'application/json'
    ])->withoutVerifying()->post(config('fship.base_url') . '/ratecalculator', $data); 
}

// Register Pickup API: Courier ko parcel uthane ke liye bulane ke liye
public function registerPickup(array $data)
{
    try {
        // PDF Rule: Isme waybills ka array bhejna hota hai [cite: 234, 236]
        $response = Http::withHeaders([
            'signature' => config('fship.signature'),
            'Content-Type' => 'application/json'
        ])
        ->withoutVerifying()
        ->post(config('fship.base_url') . '/registerpickup', $data);

        return $response;
    } catch (\Throwable $th) {
        return response()->json(['status' => false, 'response' => $th->getMessage()]);
    }
}


public function cancelOrder(array $data)
    {
        try {
            $response = Http::withHeaders([
                'signature' => config('fship.signature'),
                'Content-Type' => 'application/json'
            ])
            ->withoutVerifying()
            ->post(config('fship.base_url') . '/cancelorder', $data);

            return $response;
        } catch (\Throwable $th) {
            \Log::error('Fship Cancel Error: ' . $th->getMessage());
            return response()->json(['status' => false, 'response' => $th->getMessage()]);
        }
    }




public function getShipmentSummary(array $data)
    {
        try {
            // PDF Rule: Waybill bhej kar latest status aur courier name milta hai [cite: 326, 327]
            $response = Http::withHeaders($this->getHeaders())
                ->withoutVerifying()
                ->post(config('fship.base_url') . '/shipmentsummary', $data);

            return $response->json();
        } catch (\Throwable $th) {
            return ['status' => false, 'response' => $th->getMessage()];
        }
    }

public function getLabelDataByWaybill(array $data)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->withoutVerifying()
                ->post(config('fship.base_url') . '/shippinglabel', $data);

            return $response->json();
            
        } catch (\Throwable $th) {
            return ['status' => false, 'response' => $th->getMessage()];
        }
    }

public function generateManifest(array $pickupIds)
    {
        try {
            // PDF Rule: Ise pickupOrderId key ke andar array chahiye [cite: 441, 470]
            // Format: {"pickupOrderId": [12345]}
            $response = Http::withHeaders($this->getHeaders())
                ->withoutVerifying()
                ->post(config('fship.base_url') . '/shippinglabelbypickupid', [
                    'pickupOrderId' => $pickupIds 
                ]);

            return $response->json();
        } catch (\Throwable $th) {
            Log::error('Manifest Error: ' . $th->getMessage());
            return ['status' => false, 'response' => $th->getMessage()];
        }
    }


public function getTrackingHistory(string $waybill)
{
    try {
       
        $response = Http::withHeaders($this->getHeaders())
            ->withoutVerifying()
            ->post(config('fship.base_url') . '/trackinghistory', [
                'waybill' => $waybill
            ]);

        return $response->json();
    } catch (\Throwable $th) {
        return ['status' => false, 'response' => $th->getMessage()];
    }
}


public function createReverseOrder(array $data)
{
    try {
        $response = Http::withHeaders($this->getHeaders())
            ->withoutVerifying()
            ->post(config('fship.base_url') . '/createreverseorder', $data);

        if (!$response->successful()) {
            \Log::error('Fship Reverse Order API Error', ['body' => $response->body()]);
        }

        return $response->json();
    } catch (\Throwable $th) {
        \Log::error('Fship Reverse Order Exception: ' . $th->getMessage());
        return ['status' => false, 'response' => $th->getMessage()];
    }
}

public function reAttemptOrder(array $data)
{
    try {
        // PDF Rule: Re-attempt action tabhi allowed hai jab courier company Exception raise kare 
        $response = Http::withHeaders($this->getHeaders())
            ->withoutVerifying()
            ->post(config('fship.base_url') . '/reattemptorder', $data);

        $result = $response->json();

        // Agar API ne successful response diya (Status 200) [cite: 57]
        if ($response->successful() && isset($result['status']) && $result['status'] === true) {
            return [
                'status' => true,
                'response' => $result['response'] ?? 'Action processed successfully'
            ];
        }

        // Agar API error deti hai (Status 400, 401, 500 etc) [cite: 58, 59, 61]
        return [
            'status' => false,
            'response' => $result['response'] ?? $result['message'] ?? 'API Error: Action not allowed at this stage'
        ];

    } catch (\Throwable $th) {
        \Log::error('Fship Re-attempt API Exception: ' . $th->getMessage());
        return [
            'status' => false, 
            'response' => 'Server Error: ' . $th->getMessage()
        ];
    }
}
/**
 * Check pincode serviceability via Fship API
 * @param array $data ['source_Pincode' => '', 'destination_Pincode' => '']
 * @return array|bool
 */
public function checkPincodeServiceability(array $data)
{
    try {
        $response = Http::withHeaders([
            'signature'    => config('fship.signature'),
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json'
        ])
        ->withoutVerifying()
        ->post(config('fship.base_url') . '/pincodeserviceability', $data);

        // Return parsed JSON if successful
        if ($response->successful()) {
            return $response->json();
        }

        // Return error structure for graceful handling
        return [
            'status' => false,
            'response' => $response->body() ?: 'Serviceability check failed'
        ];

    } catch (\Throwable $th) {
        \Log::error('Fship Serviceability Check Error: ' . $th->getMessage(), [
            'data' => $data
        ]);
        return [
            'status' => false,
            'response' => 'Server error: ' . $th->getMessage()
        ];
    }
}
}