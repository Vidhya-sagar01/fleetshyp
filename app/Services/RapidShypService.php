<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class RapidShypService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        // .env file se values fetch ho rahi hain
        $this->baseUrl = env('RAPIDSHYP_API_URL', 'https://api.rapidshyp.com/rapidshyp/apis/v1');
        $this->apiKey  = env('RAPIDSHYP_API_KEY');
    }

    /**
     * RapidShyp specific headers generate karne ke liye
     */
    private function getHeaders()
    {
        return [
            'rapidshyp-token' => $this->apiKey, // PDF ke hisaab se mandatory header 
            'Content-Type'    => 'application/json', // Mandatory [cite: 9, 10]
            'Accept'          => 'application/json'
        ];
    }



    /**
 * Naya Warehouse (Pickup Address) add karne ke liye
 */


public function addWarehouse($payload)
{
    try {
        $response = Http::withHeaders($this->getHeaders()) // ✅ यही use करना है
            ->post($this->baseUrl . '/create/pickup_location', $payload);

        return [
            'status' => $response->successful() ? 'success' : 'error',
            'code'   => $response->status(),
            'body'   => $response->json(),
            'raw'    => $response->body(),
        ];

    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }
}

    /**
     * Pincode Serviceability Check karne ke liye
     */
public function getByPincode($pincode)
{
    $response = Http::withHeaders($this->getHeaders())
        ->get($this->baseUrl . '/pincode_details', ['pincode' => $pincode]);

    // Ye line aapko browser ke Network tab mein dikhayegi ki actual problem kya hai
    if ($response->failed()) {
        return [
            'error' => 'API Request Failed',
            'status' => $response->status(),
            'body' => $response->body() // Isse exact error message dikhega
        ];
    }

    return $response->json();
}

    


// Order create karne ke liye (Wrapper API)
       public function createOrder(array $orderData)
    {
        try {
            // Mandatory fields validation
            $required = [
                'orderId', 'orderDate', 'storeName', 'billingIsShipping',
                'shippingAddress', 'orderItems', 'paymentMethod', 
                'totalOrderValue', 'packageDetails'
            ];
            
            foreach ($required as $field) {
                if (!isset($orderData[$field])) {
                    return [
                        'status'  => 'error',
                        'message' => "Missing required field: {$field}"
                    ];
                }
            }

            $response = Http::withHeaders($this->getHeaders())
                ->timeout(60) // Wrapper API heavy hai, isliye zyada timeout
                ->post($this->baseUrl . '/create_order', $orderData);

            if ($response->failed()) {
                Log::error('RapidShyp Create Order Failed', [
                    'order_id' => $orderData['orderId'] ?? 'unknown',
                    'status'   => $response->status(),
                    'response' => $response->body()
                ]);
                
                return [
                    'status'  => 'error',
                    'message' => 'Order creation failed',
                    'details' => $response->json() ?? $response->body()
                ];
            }

            $result = $response->json();
            
            // Success logging (optional - production mein comment kar sakte hain)
            // Log::info('RapidShyp Order Created Successfully', [
            //     'order_id'    => $result['orderId'] ?? null,
            //     'shipment_id' => $result['shipment'][0]['shipmentId'] ?? null,
            //     'awb'         => $result['shipment'][0]['awb'] ?? null
            // ]);
            return [
                'status' => 'success',
                'data'   => $result
            ];

        } catch (\Exception $e) {
            Log::error('RapidShyp Create Order Exception', [
                'error'    => $e->getMessage(),
                'order_id' => $orderData['orderId'] ?? 'unknown'
            ]);
            
            return [
                'status'  => 'error',
                'message' => $e->getMessage()
            ];
        }
    }




 public function checkServiceability(array $data)
    {
        try {
            $required = ['Pickup_pincode', 'Delivery_pincode', 'cod', 'total_order_value', 'weight'];
            foreach ($required as $field) {
                if (!isset($data[$field])) {
                    return ['status' => 'error', 'message' => "Missing required field: {$field}", 'code' => 422];
                }
            }

            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->baseUrl . '/serviceabilty_check', $data);

            if ($response->failed()) {
                Log::error('RapidShyp Serviceability Check Failed', [
                    'request' => $data, 'status' => $response->status(), 'response' => $response->body()
                ]);
                return ['status' => 'error', 'message' => 'Serviceability check failed', 'details' => $response->json() ?? $response->body(), 'code' => $response->status()];
            }

            $result = $response->json();
            if (!($result['status'] ?? false)) {
                return ['status' => 'error', 'message' => $result['remark'] ?? 'Serviceability check failed', 'data' => $result, 'code' => 200];
            }

            return ['status' => 'success', 'data' => $result, 'code' => 200];

        } catch (\Exception $e) {
            Log::error('RapidShyp Serviceability Exception', ['error' => $e->getMessage(), 'request' => $data]);
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
        }
    }

    
    /**
     * ✅ Assign AWB to Shipment - POST /assign_awb
     */
    public function assignAWB(string $shipmentId, string $courierCode = '')
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->baseUrl . '/assign_awb', ['shipment_id' => $shipmentId, 'courier_code' => $courierCode]);

            if ($response->failed()) {
                return ['status' => 'error', 'details' => $response->body(), 'code' => $response->status()];
            }

            $result = $response->json();
            if (($result['status'] ?? '') !== 'SUCCESS') {
                return ['status' => 'error', 'message' => $result['remarks'] ?? 'AWB assignment failed', 'data' => $result, 'code' => 422];
            }

            return ['status' => 'success', 'data' => $result, 'code' => 200];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
        }
    }
    


 /**
     * ✅ Schedule Pickup - POST /schedule_pickup
     */
    public function schedulePickup(string $shipmentId, string $awb = '')
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->baseUrl . '/schedule_pickup', ['shipment_id' => $shipmentId, 'awb' => $awb]);

            if ($response->failed()) {
                return ['status' => 'error', 'details' => $response->body(), 'code' => $response->status()];
            }

            $result = $response->json();
            if (($result['status'] ?? '') !== 'SUCCESS') {
                return ['status' => 'error', 'message' => $result['remarks'] ?? 'Pickup scheduling failed', 'data' => $result, 'code' => 422];
            }

            return ['status' => 'success', 'data' => $result, 'code' => 200];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
        }
    }

     /**
     * ✅ Generate Label PDF - POST /generate_label
     */
    public function generateLabel(array $shipmentIds)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->baseUrl . '/generate_label', ['shipmentId' => $shipmentIds]);

            if ($response->failed()) {
                return ['status' => 'error', 'details' => $response->body(), 'code' => $response->status()];
            }

            $result = $response->json();
            if (!($result['status'] ?? false)) {
                return ['status' => 'error', 'message' => $result['remarks'] ?? 'Label generation failed', 'data' => $result, 'code' => 422];
            }

            return ['status' => 'success', 'data' => $result, 'code' => 200];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
        }
    }

     /**
     * ✅ Generate Invoice PDF - POST /generate_invoice
     */
    public function generateInvoice(array $shipmentIds)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->baseUrl . '/generate_invoice', ['shipmentId' => $shipmentIds]);

            if ($response->failed()) {
                return ['status' => 'error', 'details' => $response->body(), 'code' => $response->status()];
            }

            $result = $response->json();
            if (!($result['status'] ?? false)) {
                return ['status' => 'error', 'message' => $result['remarks'] ?? 'Invoice generation failed', 'data' => $result, 'code' => 422];
            }

            return ['status' => 'success', 'data' => $result, 'code' => 200];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
        }
    }


     /**
     * ✅ Cancel Order - POST /cancel_order
     */
    public function cancelOrder(string $orderId, string $storeName = 'DEFAULT')
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->baseUrl . '/cancel_order', ['orderId' => $orderId, 'storeName' => $storeName]);

            if ($response->failed()) {
                return ['status' => 'error', 'details' => $response->body(), 'code' => $response->status()];
            }

            $result = $response->json();
            if (!($result['status'] ?? false)) {
                return ['status' => 'error', 'message' => $result['remarks'] ?? 'Order cancellation failed', 'data' => $result, 'code' => 422];
            }

            return ['status' => 'success', 'data' => $result, 'code' => 200];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
        }
    }


    /**
     * ✅ Track Order - POST /track_order
     */
    public function trackOrder(array $params)
    {
        try {
            if (!isset($params['seller_order_id']) && !isset($params['awb'])) {
                return ['status' => 'error', 'message' => 'Either seller_order_id or awb is required', 'code' => 422];
            }

            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->baseUrl . '/track_order', $params);

            if ($response->failed()) {
                return ['status' => 'error', 'details' => $response->body(), 'code' => $response->status()];
            }

            $result = $response->json();
            if (!($result['success'] ?? false)) {
                return ['status' => 'error', 'message' => $result['msg'] ?? 'Tracking info not available', 'data' => $result, 'code' => 404];
            }

            return ['status' => 'success', 'data' => $result, 'code' => 200];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
        }
    }



     /**
     * ✅ De-allocate Shipment - POST /de_allocate_shipment
     */
    public function deAllocateShipment(string $orderId, string $shipmentId)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->baseUrl . '/de_allocate_shipment', ['orderId' => $orderId, 'shipmentId' => $shipmentId]);

            if ($response->failed()) {
                return ['status' => 'error', 'details' => $response->body(), 'code' => $response->status()];
            }

            $result = $response->json();
            if (!($result['status'] ?? false)) {
                return ['status' => 'error', 'message' => $result['remarks'] ?? 'De-allocation failed', 'data' => $result, 'code' => 422];
            }

            return ['status' => 'success', 'data' => $result, 'code' => 200];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 500];
        }
    }

}