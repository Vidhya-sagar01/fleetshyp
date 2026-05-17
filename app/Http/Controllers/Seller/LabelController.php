<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingLabel;
use App\Models\FshipOrder;
use App\Models\Wallet;
use App\Models\Wallet_transaction;
use App\Services\FshipService;
use App\Models\PickupAddress;
use App\Models\LabelSetting;
use App\Models\ShipmentDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Milon\Barcode\Facades\DNS1D;
use Illuminate\Support\Facades\Auth;


class LabelController extends Controller
{
    protected $fshipService;

    public function __construct(FshipService $fshipService)
    {
        $this->fshipService = $fshipService;
    }

    public function index()
    {
        return view('seller.leble.index');
    }

    /**
     * Settings Update logic (Save Template Preferences)
     */
     

public function update(Request $request)
{
    try {
        $validated = $request->validate([
            'display_name'      => 'required|string|max:255',
            'printer'           => 'required|string|in:A4 Size,Thermal 4x6,Thermal 4x4,Standard A4',
            'template'          => 'required|string|in:Thermal 4x4,Standard A4',
            'show_signature'    => 'nullable|boolean',
            'template_settings' => 'nullable|array',
        ]);

        // ✅ Ensure template_settings has all keys with boolean values
        $templateSettings = $validated['template_settings'] ?? [];
        
        // Default settings structure
        $defaultSettings = [
            'consignee' => true,
            'products' => true,
            'return_address' => false,
            'warehouse_contact' => false,
            'seller_contact' => false,
            'gst' => false,
            'gst_breakup' => false,
            'order_id' => true,
            'sku' => true,
            'amount' => true,
            'product_name' => true,
        ];

        // Merge with defaults
        $finalSettings = array_merge($defaultSettings, $templateSettings);

        // ✅ Prepare data for save
        $data = [
            'user_id' => Auth::id(),
            'label_display_name' => $validated['display_name'],
            'label_printer' => $validated['printer'],
            'label_template' => $validated['template'],
            'show_signature_on_label' => isset($validated['show_signature']) ? 1 : 0,
            'template_settings' => $finalSettings,
        ];

        // ✅ Update or create settings
        \App\Models\LabelSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return response()->json([
            'success' => true, 
            'message' => '✅ Template settings saved successfully!'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        Log::error('Label Settings Update Error', [
            'user_id' => Auth::id(),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => '❌ Failed to save settings: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Bulk Action Handler (AJAX Router)
     */
    public function bulkAction(Request $request)
    {
        $action = $request->action;
    
        $orderIds = $request->order_ids;

        if (empty($orderIds)) {
            return response()->json(['success' => false, 'message' => 'No orders selected']);
        }

        switch ($action) {
            case 'cancel':
                return $this->bulkCancel($orderIds);
            case 'manifest':
                return $this->bulkManifestLogic($orderIds);
            case 'download-label':
                return response()->json([
                    'success' => true,
                    'download_url' => route('orders.print-label', ['ids' => implode(',', $orderIds)])
                ]);
            default:
                return response()->json(['success' => false, 'message' => 'Invalid Action']);
        }
    }

   
 
// public function bulkPrintLabel($ids)
//     {
//         // Bulk download ke liye limit badha dein
//         ini_set('memory_limit', '512M');
//         set_time_limit(300);

//         $orderIds = explode(',', $ids);
        
//         // Sirf wahi order uthayein jinka AWB generate ho chuka hai
//         $orders = FshipOrder::with(['items', 'pickupAddress'])
//                             ->whereIn('id', $orderIds)
//                             ->whereNotNull('waybill')
//                             ->get();

//         if ($orders->isEmpty()) {
//             return back()->with('error', 'Selected orders ka AWB generate nahi hua hai.');
//         }

//         // ====================================================
//         // 🚀 AUTO-MANIFEST LOGIC (Register Pickup & Update DB)
//         // ====================================================
//         $waybills = $orders->pluck('waybill')->toArray();

//         try {
//             // 1. Fship API par pickup register karein (Taaki courier boy aaye)
//             $pickupResponse = $this->fshipService->registerPickup([
//                 'waybills' => $waybills
//             ]);

//             // 2. Apne local database mein sabhi selected orders ka status 'manifested' kar dein
//             FshipOrder::whereIn('id', $orders->pluck('id'))->update(['status' => 'manifested']);
            
//         } catch (\Exception $e) {
//             // Agar API down bhi ho, tab bhi code crash na ho aur label download ho jaye
//             \Log::error('Auto Manifest Failed: ' . $e->getMessage());
//         }
//         // ====================================================

//         // Settings aur Company profile fetch karein
//         $labelSetting = LabelSetting::where('user_id', Auth::id())->first();
//         if (!$labelSetting) {
//             $labelSetting = (object)[
//                 'printer' => 'Standard A4',
//                 'display_name' => Auth::user()->name ?? 'Company',
//                 'show_signature' => 0,
//                 'template_settings' => []
//             ];
//         }

//         $company = \App\Models\CompanyProfile::where('seller_id', Auth::id())->first();

        
//         $pdf = Pdf::loadView('seller.leble.pdf_template', [
//             'orders'   => $orders,
//             'label'    => $labelSetting,
//             'settings' => $labelSetting->template_settings ?? [],
//             'company'  => $company 
//         ]);

       
//         $pdf->getDomPDF()->set_option("isHtml5ParserEnabled", true);
//         $pdf->getDomPDF()->set_option("isRemoteEnabled", true);

        
//         $paperSize = ($labelSetting->printer === 'Thermal 4x6') ? [0, 0, 288, 432] : 'a4';

       
//         return $pdf->setPaper($paperSize, 'portrait')
//                     ->download("Shipping-Labels-" . date('Ymd_His') . ".pdf");
//     }

// public function bulkPrintLabel($ids)
// {
//     // Bulk download ke liye limit badha dein
//     ini_set('memory_limit', '512M');
//     set_time_limit(300);

//     $orderIds = explode(',', $ids);
    
//     // ✅ Sirf wahi order uthayein jinka AWB generate ho chuka hai
//     $orders = FshipOrder::with(['items', 'pickupAddress'])
//                         ->whereIn('id', $orderIds)
//                         ->whereNotNull('waybill')
//                         ->get();

//     if ($orders->isEmpty()) {
//         return back()->with('error', 'Selected orders ka AWB generate nahi hua hai.');
//     }

//     // ====================================================
//     // 🚀 AUTO-MANIFEST LOGIC (Register Pickup & Update DB)
//     // ====================================================
//     $waybills = $orders->pluck('waybill')->toArray();

//     try {
//         // 1. Fship API par pickup register karein
//         $pickupResponse = $this->fshipService->registerPickup([
//             'waybills' => $waybills
//         ]);

//         // 2. Apne local database mein sabhi selected orders ka status 'manifested' kar dein
//         FshipOrder::whereIn('id', $orders->pluck('id'))
//                   ->update(['status' => 'manifested']);
        
//     } catch (\Exception $e) {
//         // Agar API down bhi ho, tab bhi code crash na ho
//         \Log::error('Auto Manifest Failed: ' . $e->getMessage());
//     }
//     // ====================================================

//     // ✅ Settings fetch karein - USE CORRECT MODEL
//     $labelSetting = \App\Models\LabelSetting::where('user_id', Auth::id())->first();
    
//     if (!$labelSetting) {
//         // Default settings agar exist nahi karte
//         $labelSetting = (object)[
//             'label_printer' => 'A4 Size',
//             'label_display_name' => Auth::user()->name ?? 'Company Name',
//             'show_signature_on_label' => 0,
//             'template_settings' => [
//                 'consignee' => true,
//                 'products' => true,
//                 'return_address' => false,
//                 'warehouse_contact' => false,
//                 'seller_contact' => false,
//                 'gst' => false,
//                 'gst_breakup' => false,
//                 'order_id' => true,
//                 'sku' => true,
//                 'amount' => true,
//                 'product_name' => true,
//             ]
//         ];
//     }

//     // ✅ Company profile fetch karein
//     $company = \App\Models\CompanyProfile::where('seller_id', Auth::id())->first();

//     // ✅ Settings ko array mein convert karein
//     $settings = is_array($labelSetting->template_settings) 
//         ? $labelSetting->template_settings 
//         : json_decode($labelSetting->template_settings, true) ?? [];
//     // ✅ PDF generate karein with correct view path
//     $pdf = \PDF::loadView('seller.lable.pdf_template', [ // ✅ Check view path
//         'orders'   => $orders,
//         'label'    => $labelSetting,
//         'settings' => $settings,
//         'company'  => $company 
//     ]);

//     // ✅ PDF options set karein
//     $pdf->getDomPDF()->set_option("isHtml5ParserEnabled", true);
//     $pdf->getDomPDF()->set_option("isRemoteEnabled", true);
//     $pdf->getDomPDF()->set_option("isPhpEnabled", true);

//     // ✅ Paper size set karein based on printer type
//     $paperSize = 'a4'; // Default
    
//     if (stripos($labelSetting->label_printer ?? '', 'thermal') !== false) {
//         // Thermal 4x6 inches = 288 x 432 points
//         $paperSize = [0, 0, 288, 432];
//     }

//     return $pdf->setPaper($paperSize, 'portrait')
//                ->download("Shipping-Labels-" . date('Ymd_His') . ".pdf");
// }

public function bulkPrintLabel($ids)
{
    // Bulk download ke liye limit badha dein
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    $orderIds = explode(',', $ids);
    
    // ✅ Sirf wahi order uthayein jinka AWB generate ho chuka hai
    $orders = FshipOrder::with(['items', 'pickupAddress'])
                        ->whereIn('id', $orderIds)
                        ->whereNotNull('waybill')
                        ->get();

    if ($orders->isEmpty()) {
        return back()->with('error', 'Selected orders ka AWB generate nahi hua hai.');
    }

    // ====================================================
    // 🚀 AUTO-MANIFEST LOGIC
    // ====================================================
    $waybills = $orders->pluck('waybill')->toArray();

    try {
        $pickupResponse = $this->fshipService->registerPickup([
            'waybills' => $waybills
        ]);

        FshipOrder::whereIn('id', $orders->pluck('id'))
                  ->update(['status' => 'manifested']);
        
    } catch (\Exception $e) {
        \Log::error('Auto Manifest Failed: ' . $e->getMessage());
    }
    // ====================================================

    // ✅ Fetch logged-in user details
    $user = Auth::user();
    
    // ✅ Fetch user's RTO address (if exists)
    $rtoAddress = \App\Models\RtoAddress::where('pickup_address_id', $user->id)->first();
    
    // ✅ Fetch label settings
    $labelSetting = \App\Models\LabelSetting::where('user_id', $user->id)->first();
    
    if (!$labelSetting) {
        $labelSetting = (object)[
            'label_printer' => 'A4 Size',
            'label_display_name' => $user->name ?? 'Company Name',
            'show_signature_on_label' => 0,
            'template_settings' => [
                'consignee' => true,
                'products' => true,
                'return_address' => false,
                'warehouse_contact' => false,
                'seller_contact' => false,
                'gst' => false,
                'gst_breakup' => false,
                'order_id' => true,
                'sku' => true,
                'amount' => true,
                'product_name' => true,
            ]
        ];
    }

    // ✅ Company profile fetch karein
    $company = \App\Models\CompanyProfile::where('seller_id', $user->id)->first();

    // ✅ Settings ko array mein convert karein
    $settings = is_array($labelSetting->template_settings) 
        ? $labelSetting->template_settings 
        : json_decode($labelSetting->template_settings, true) ?? [];

    // ✅ PDF generate karein with ALL required data
    $pdf = \PDF::loadView('seller.leble.pdf_template', [
        'orders'         => $orders,
        'label'          => $labelSetting,
        'settings'       => $settings,
        'company'        => $company,
        'user'           => $user,              // ✅ Logged-in user
        'rtoAddress'     => $rtoAddress,        // ✅ RTO address from table
        'sellerPhone'    => $user->phone ?? '+91 XXXXX XXXXX',  // ✅ From users table
        'sellerEmail'    => $user->email ?? 'seller@example.com', // ✅ From users table
    ]);

    // ✅ PDF options set karein
    $pdf->getDomPDF()->set_option("isHtml5ParserEnabled", true);
    $pdf->getDomPDF()->set_option("isRemoteEnabled", true);
    $pdf->getDomPDF()->set_option("isPhpEnabled", true);

    // ✅ Paper size set karein
    $paperSize = 'a4';
    
    if (stripos($labelSetting->label_printer ?? '', 'thermal') !== false) {
        $paperSize = [0, 0, 288, 432]; // Thermal 4x6
    }

    return $pdf->setPaper($paperSize, 'portrait')
               ->download("Shipping-Labels-" . date('Ymd_His') . ".pdf");
}




// public function bulkCancel(\Illuminate\Http\Request $request)
// {
//   //  dd($request->all());
//     $orderIds = $request->order_ids;
//     if (empty($orderIds)) {
//         return response()->json(['success' => false, 'message' => 'No orders selected.']);
//     }

//     // PDF Rule: Booked ya Manifested state check 
//     $orders = FshipOrder::whereIn('id', $orderIds)
//                 ->whereNotNull('waybill')
//                 ->whereIn(\DB::raw('LOWER(status)'), ['booked', 'manifested']) 
//                 ->get();
    
//     if ($orders->isEmpty()) {
//         return response()->json(['success' => false, 'message' => 'No valid orders found to cancel.']);
//     }

//     $successCount = 0;
//     $errors = [];

//     foreach ($orders as $order) {
//         // PDF Rule: cancelorder API requires waybill and reason [cite: 203, 204]
//         $response = $this->fshipService->cancelOrder([
//             'waybill' => (string)$order->waybill, 
//             'reason'  => 'Cancelled by Seller' 
//         ]);
        
//         // Response check as per PDF [cite: 228]
//         $resData = $response->json();
//         if (isset($resData['status']) && $resData['status'] === true) {
//             \DB::beginTransaction();
//             try {
//                 // Wallet Refund Logic
//                 $refundAmount = (float)($order->forward_charge ?? 0) + (float)($order->cod_charge ?? 0);
//                 if ($refundAmount > 0) {
//                     $wallet = \App\Models\Wallet::where('user_id', $order->user_id)->lockForUpdate()->first();
//                     if ($wallet) {
//                         $wallet->increment('balance', $refundAmount);
//                         // Log Transaction...
//                     }
//                 }

//                 $order->status = 'cancelled';
//                 $order->save();

//                 \DB::commit();
//                 $successCount++;
//             } catch (\Exception $e) {
//                 \DB::rollBack();
//                 $errors[] = "AWB {$order->waybill}: Refund failed.";
//             }
//         } else {
//             $errors[] = "AWB {$order->waybill}: " . ($resData['response'] ?? 'API Error');
//         }
//     }

//     return response()->json([
//         'success' => $successCount > 0,
//         'message' => $successCount . " shipment(s) cancelled.",
//         'errors'  => $errors
//     ]);
// }



public function bulkCancel(\Illuminate\Http\Request $request)
{
    $orderIds = $request->input('order_ids');
    
    if (empty($orderIds)) {
        return response()->json(['success' => false, 'message' => 'No orders selected.']);
    }
    
    $orders = FshipOrder::whereIn('id', $orderIds)
        ->whereIn('status', ['NEW', 'booked', 'manifested', 'draft'])
        ->get();
    
    if ($orders->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'No valid orders found to cancel.']);
    }
    
    $successCount = 0;
    $errors = [];
    
    foreach ($orders as $order) {
        DB::beginTransaction();
        try {
            \Log::info('Order Cancellation Started', [
                'order_id' => $order->id,
                'merchant_order_id' => $order->merchant_order_id,
                'user_id' => $order->user_id,
                'wallet_deduction_amount' => $order->wallet_deduction_amount,
                'is_refunded' => $order->is_refunded
            ]);

            // ✅ 1. Double refund protection
            if ($order->is_refunded == 1) {
                $errors[] = "Order #{$order->merchant_order_id}: Already refunded";
                DB::rollBack();
                continue;
            }
          
            // ✅ 2. API cancel (if AWB exists)
            if (!empty($order->waybill)) {
                $response = $this->fshipService->cancelOrder([
                    'waybill' => (string)$order->waybill,
                    'reason'  => 'Cancelled by Seller'
                ]);
               
                $resData = $response->json();
                
                if (!isset($resData['status']) || $resData['status'] !== true) {
                    $errors[] = "AWB {$order->waybill}: " . ($resData['response'] ?? 'API Error');
                    \Log::error('API Cancel Failed', ['resData' => $resData]);
                    DB::rollBack();
                    continue;
                }
            }
            
            // ✅ 3. CORRECT REFUND - यहाँ issue है
            $refundAmount = (float) ($order->wallet_deduction_amount ?? 0);
            
            \Log::info('Refund Amount Calculated', [
                'refundAmount' => $refundAmount,
                'user_id' => $order->user_id
            ]);
            
            if ($refundAmount > 0) {
                // Check if wallet exists
                $wallet = Wallet::where('user_id', $order->user_id)->first();
                
                \Log::info('Wallet Check', [
                    'wallet_exists' => $wallet ? true : false,
                    'user_id' => $order->user_id,
                    'wallet_balance_before' => $wallet ? $wallet->balance : 'N/A'
                ]);
                
                if (!$wallet) {
                    \Log::warning('Wallet does not exist, creating new wallet', [
                        'user_id' => $order->user_id
                    ]);
                    // Create wallet if doesn't exist
                    $wallet = Wallet::create([
                        'user_id' => $order->user_id,
                        'balance' => 0
                    ]);
                }
                
                // Use lock for update
                $wallet = Wallet::where('user_id', $order->user_id)
                    ->lockForUpdate()
                    ->first();
                
                $opening = (float) $wallet->balance;
                
                // Credit wallet
                $wallet->balance = $wallet->balance + $refundAmount;
                $wallet->save();
                
                $wallet->refresh();
                $closing = (float) $wallet->balance;
                
                \Log::info('Wallet Updated', [
                    'user_id' => $order->user_id,
                    'opening_balance' => $opening,
                    'refund_amount' => $refundAmount,
                    'closing_balance' => $closing,
                    'wallet_id' => $wallet->id
                ]);
                
                // ✅ Correct transaction log
                $transaction = Wallet_transaction::create([
                    'user_id' => $order->user_id,
                    'fship_order_id' => $order->id,
                    'amount' => $refundAmount,
                    'type' => 'credit',
                    'charge_type' => 'refund',
                    'source' => 'order_cancellation',
                    'opening_balance' => $opening,
                    'closing_balance' => $closing,
                    'remark' => "Refund for cancelled order #{$order->merchant_order_id}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                \Log::info('Transaction Created', [
                    'transaction_id' => $transaction->id,
                    'user_id' => $order->user_id,
                    'amount' => $refundAmount
                ]);
            } else {
                \Log::warning('No refund amount to process', [
                    'order_id' => $order->id,
                    'wallet_deduction_amount' => $order->wallet_deduction_amount
                ]);
            }
            
            // ✅ 4. STATUS UPDATE (AFTER REFUND)
            $order->update([
                'status' => 'cancelled',
                'is_refunded' => 1
            ]);
            
            \Log::info('Order Status Updated', [
                'order_id' => $order->id,
                'new_status' => 'cancelled'
            ]);
            
            DB::commit();
            $successCount++;
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Bulk Cancel Failed', [
                'order_id' => $order->id,
                'merchant_order_id' => $order->merchant_order_id,
                'waybill' => $order->waybill,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $errors[] = "Order #{$order->merchant_order_id}: " . $e->getMessage();
        }
    }
    
    return response()->json([
        'success' => $successCount > 0,
        'message' => "$successCount order(s) cancelled successfully.",
        'errors' => $errors,
        'details' => [
            'total_processed' => count($orders),
            'successful' => $successCount,
            'failed' => count($errors)
        ]
    ]);
}





// public function bulkClone(\Illuminate\Http\Request $request)
// {
   
//     $orderIds = $request->order_ids;

//     if (empty($orderIds)) {
//         return response()->json(['success' => false, 'message' => 'No orders selected to clone.']);
//     }

//     $successCount = 0;
//     $errors = [];
    
   
//     $fshipService = new \App\Services\FshipService(); 

  
//     $orders =FshipOrder::with('items')->whereIn('id', $orderIds)->get();
//     //dd($orders);
//     foreach ($orders as $originalOrder) {
//         \DB::beginTransaction();
//         try {
           
//             $newOrder = $originalOrder->replicate();
          
//             $newOrder->merchant_order_id = $originalOrder->merchant_order_id . '-CLONE-' . rand(100, 999);
            
        
//             $newOrder->fship_api_order_id = null; 
//             $newOrder->waybill = null; 
//             $newOrder->pickup_order_id = null; 
//             $newOrder->status = 'NEW'; 
//             $newOrder->save();

//             // 2. Items Replicate karein
//             foreach ($originalOrder->items as $item) {
//                 $newItem = $item->replicate();
//                 $newItem->fship_order_id = $newOrder->id;
//                 $newItem->save();
//             }

        
//             $volumetricWeight = ((float)$newOrder->length * (float)$newOrder->width * (float)$newOrder->height) / 5000; // 
//             $chargeableWeight = max((float)$newOrder->weight, $volumetricWeight);
//             $totalAmount = (float)$newOrder->product_subtotal;
          
           
//             $apiPayload = [
//                 "customer_Name"         => $newOrder->buyer_name,
//                 "customer_Mobile"       => $newOrder->phone_number,  
//                 "customer_Emailid"      => $newOrder->email_id ?? "",
//                 "customer_Address"      => $newOrder->complete_address,
//                 "customer_PinCode"      => $newOrder->pincode, 
//                 "customer_City"         => $newOrder->city, 
//                 "customer_Address_Type" => "Home",  
//                 "orderId"               => $newOrder->merchant_order_id,  
//                 "payment_Mode"          => (int)$newOrder->payment_mode,
//                 "product_Subtotal"      => round($totalAmount, 2),
//                 "product_Subtotal" => round($totalAmount, 2),
//                 "product_Subtotal"  => round($totalAmount, 2), 
//                 "total_Amount"      => round($totalAmount, 2), 
//                 "Total_Amount"      => round($totalAmount, 2),
//                 "cod_Amount"            => $newOrder->payment_mode == 1 ? round($totalAmount, 2) : 0, 
//                 "shipment_Weight"       => round($chargeableWeight, 3), 
//                 "shipment_Length"       => round((float)$newOrder->length, 2), 
//                 "shipment_Width"        => round((float)$newOrder->width, 2),
//                 "shipment_Height"       => round((float)$newOrder->height, 2), 
//                 "volumetric_Weight"     => round($volumetricWeight, 3), 
//                 "pick_Address_ID"       => (int)$newOrder->pick_address_ID, 
//                 "products" => $newOrder->items->map(function($item) {
//                     return [
//                         "productName" => $item->product_name,
//                         "unitPrice"   => (float)$item->unit_price, 
//                         "quantity"    => (int)$item->quantity, 
//                         "sku"         => $item->sku ?? "NA" 
//                     ];
//                 })->toArray()
//             ];

            
//             $apiResponse = $fshipService->createForwardOrder($apiPayload);
//             dd()
//           // dd($apiResponse);
//             if (isset($apiResponse['status']) && $apiResponse['status'] === true && isset($apiResponse['waybill'])) {
                
//                 $newOrder->update([
//                     'waybill'            => $apiResponse['waybill'], // [cite: 156]
//                     'fship_api_order_id' => $apiResponse['apiorderid'], // [cite: 155]
//                     'status'             => 'NEW',
//                     'volumetric_weight'  => $volumetricWeight
//                 ]);
                
//                 \DB::commit();
//                 $successCount++;
//             } else {
              
//                 \DB::rollBack();
//                 $errorMsg = $apiResponse['response'] ?? $apiResponse['message'] ?? 'Fship API did not return a Waybill number.';
//                 $errors[] = "Order #{$newOrder->merchant_order_id} API Error: " . $errorMsg;
//             }

//         } catch (\Exception $e) {

//             \DB::rollBack();
//             dd($e->getMessage());
//             $errors[] = "Order #{$originalOrder->merchant_order_id} Internal Error: " . $e->getMessage();
//         }
//     }

//     return response()->json([
//         'success' => $successCount > 0,
//         'message' => "Successfully cloned and booked $successCount orders.",
//         'errors' => $errors
//     ]);
// }
// public function bulkClone(\Illuminate\Http\Request $request)
// {
//     $orderIds = $request->input('order_ids');

//     if (empty($orderIds)) {
//         return response()->json(['success' => false, 'message' => 'No orders selected to clone.']);
//     }

//     $successCount = 0;
//     $errors = [];
    
//     // Fetch orders with items
//     $orders = \App\Models\FshipOrder::with('items')->whereIn('id', $orderIds)->get();

//     foreach ($orders as $originalOrder) {
//         \DB::beginTransaction();
//         try {
//             // 1. Replicate main order
//             $newOrder = $originalOrder->replicate();
            
//             // Generate new unique merchant_order_id
//             $newOrder->merchant_order_id = $originalOrder->merchant_order_id . '-CLONE-' . rand(100, 999);
            
//             // Reset FShip related fields (since not booked yet)
//             $newOrder->fship_api_order_id = null; 
//             $newOrder->waybill = null; 
//             $newOrder->pickup_order_id = null; 
//             $newOrder->status = 'NEW'; // Reset to draft/new state
//             $newOrder->booked_at = null;
//             $newOrder->expected_delivery_date = null;
//             $newOrder->created_at = now();
//             $newOrder->updated_at = now();
//             $newOrder->save();

//             // 2. Replicate order items
//             foreach ($originalOrder->items as $item) {
//                 $newItem = $item->replicate();
//                 $newItem->fship_order_id = $newOrder->id;
//                 $newItem->created_at = now();
//                 $newItem->updated_at = now();
//                 $newItem->save();
//             }

//             // ✅ No FShip API call — order is cloned locally only
//             // Seller can book it later manually from dashboard
            
//             \DB::commit();
//             $successCount++;
            
//         } catch (\Exception $e) {
//             \DB::rollBack();
//             \Log::error('Clone Failed: ' . $e->getMessage(), [
//                 'order_id' => $originalOrder->id,
//                 'merchant_order_id' => $originalOrder->merchant_order_id
//             ]);
//             $errors[] = "Order #{$originalOrder->merchant_order_id}: " . $e->getMessage();
//         }
//     }

//     return response()->json([
//         'success' => $successCount > 0,
//         'message' => "$successCount order(s) cloned successfully. You can book them later from dashboard.",
//         'errors' => $errors
//     ]);
// }
// public function bulkClone(\Illuminate\Http\Request $request)
// {
//     $orderIds = $request->input('order_ids');

//     if (empty($orderIds)) {
//         return response()->json(['success' => false, 'message' => 'No orders selected to clone.']);
//     }

//     $successCount = 0;
//     $errors = [];
    
//     // Fetch orders with items
//     $orders = \App\Models\FshipOrder::with('items')->whereIn('id', $orderIds)->get();

//     foreach ($orders as $originalOrder) {
//         \DB::beginTransaction();
//         try {
//             // 1. Replicate main order
//             $newOrder = $originalOrder->replicate();
            
//             // Generate new unique merchant_order_id
//             $newOrder->merchant_order_id = $originalOrder->merchant_order_id . '-CLONE-' . rand(100, 999);
            
//             // ✅ Reset FShip related fields (since not booked yet)
//             $newOrder->fship_api_order_id = null; 
//             $newOrder->waybill = null; 
//             $newOrder->pickup_order_id = null; 
            
//             // ✅ FIXED: Always set status to 'NEW' regardless of original status
//             // Even if original was 'cancelled', cloned order will be 'NEW' (ready to book)
//             $newOrder->status = 'NEW';
            
//             // Reset booking/delivery related fields
//             $newOrder->booked_at = null;
//             $newOrder->expected_delivery_date = null;
//             $newOrder->cancelled_at = null; // ✅ Clear cancelled_at if exists
//             $newOrder->created_at = now();
//             $newOrder->updated_at = now();
//             $newOrder->save();

//             // 2. Replicate order items
//             foreach ($originalOrder->items as $item) {
//                 $newItem = $item->replicate();
//                 $newItem->fship_order_id = $newOrder->id;
//                 $newItem->created_at = now();
//                 $newItem->updated_at = now();
//                 $newItem->save();
//             }

//             // ✅ No FShip API call — order is cloned locally only
//             // Seller can book it later manually from dashboard
            
//             \DB::commit();
//             $successCount++;
            
//         } catch (\Exception $e) {
//             \DB::rollBack();
//             \Log::error('Clone Failed: ' . $e->getMessage(), [
//                 'order_id' => $originalOrder->id,
//                 'merchant_order_id' => $originalOrder->merchant_order_id
//             ]);
//             $errors[] = "Order #{$originalOrder->merchant_order_id}: " . $e->getMessage();
//         }
//     }

//     return response()->json([
//         'success' => $successCount > 0,
//         'message' => "$successCount order(s) cloned successfully. Cloned orders are in 'NEW' status and ready to book.",
//         'errors' => $errors
//     ]);
// }
public function bulkClone(\Illuminate\Http\Request $request)
{
    $orderIds = $request->input('order_ids');

    if (empty($orderIds)) {
        return response()->json(['success' => false, 'message' => 'No orders selected to clone.']);
    }

    $successCount = 0;
    $errors = [];
    
    // Fetch orders with items
    $orders = \App\Models\FshipOrder::with('items')->whereIn('id', $orderIds)->get();

    foreach ($orders as $originalOrder) {
        \DB::beginTransaction();
        try {
            // 1. Replicate main order
            $newOrder = $originalOrder->replicate();
            
            // Generate new unique merchant_order_id
            $newOrder->merchant_order_id = $originalOrder->merchant_order_id . '-CLONE-' . rand(100, 999);
            
            // ✅ Reset FShip related fields (since not booked yet)
            $newOrder->fship_api_order_id = null; 
            $newOrder->waybill = null; 
            $newOrder->pickup_order_id = null; 
            
            // ✅ FIXED: Always set status to 'NEW' regardless of original status
            $newOrder->status = 'NEW';
            
            // Reset booking/delivery related fields
            $newOrder->booked_at = null;
            $newOrder->expected_delivery_date = null;
            // ✅ REMOVED: $newOrder->cancelled_at = null; // Column doesn't exist
            $newOrder->created_at = now();
            $newOrder->updated_at = now();
            $newOrder->save();

            // 2. Replicate order items
            foreach ($originalOrder->items as $item) {
                $newItem = $item->replicate();
                $newItem->fship_order_id = $newOrder->id;
                $newItem->created_at = now();
                $newItem->updated_at = now();
                $newItem->save();
            }

            // ✅ No FShip API call — order is cloned locally only
            // Seller can book it later manually from dashboard
            
            \DB::commit();
            $successCount++;
            
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Clone Failed: ' . $e->getMessage(), [
                'order_id' => $originalOrder->id,
                'merchant_order_id' => $originalOrder->merchant_order_id
            ]);
            $errors[] = "Order #{$originalOrder->merchant_order_id}: " . $e->getMessage();
        }
    }

    return response()->json([
        'success' => $successCount > 0,
        'message' => "$successCount order(s) cloned successfully. Cloned orders are in 'NEW' status and ready to book.",
        'errors' => $errors
    ]);
}



public function exportExcel(Request $request)
{
    
    if (!$request->has('ids') || empty($request->ids)) {
        return back()->with('error', 'Please select at least one order.');
    }

    $ids = explode(',', $request->ids);
    
  
    $orders = \App\Models\FshipOrder::with(['pickupAddress', 'items'])
                   ->whereIn('id', $ids)
                   ->get();

    if ($orders->isEmpty()) {
        return back()->with('error', 'No orders found.');
    }

    $fileName = 'Orders_Export_' . date('d-m-Y_H-i') . '.csv';

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

   
    $columns = [
        'Order Date', 'Zone', 'State', 'Order ID', 'AWB Number', 
        'Status', 'Order Type', 'Payment Mode', 'Product Subtotal', 
        'Total Amount', 'Customer Name', 'City', 'Phone', 
        'Pickup ID', 'Product Details', 'Weight (Kg)', 'Dimensions (LxWxH)'
    ];

    $callback = function() use($orders, $columns) {
        $file = fopen('php://output', 'w');
        
       
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($file, $columns);

        foreach ($orders as $order) {
           
            $productDetails = "";
            foreach ($order->items as $item) {
                $productDetails .= $item->product_name . " (x" . $item->quantity . ") | ";
            }
            $productDetails = rtrim($productDetails, ' | ');

            // Ek row likhein (Aapke database column names ke mutabiq)
            fputcsv($file, [
                $order->created_at ? $order->created_at->format('d-M-Y h:i A') : '',
                $order->zone ?? 'N/A',
                $order->state,
                $order->merchant_order_id,
                $order->waybill ?? 'N/A',
                strtoupper($order->status),
                $order->order_type ?? 'N/A',
                ($order->payment_mode == 1 ? 'COD' : 'PREPAID'),
                $order->product_subtotal,
                $order->total_amount,
                $order->buyer_name,
                $order->city,
                $order->phone_number,
                $order->pick_address_ID,
                $productDetails,
                $order->weight,
                (int)$order->length . "x" . (int)$order->width . "x" . (int)$order->height
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}





// public function bulkManifest(Request $request, FshipService $fship)
// {
//     $orderIds = $request->input('order_ids');
//     if (!$orderIds) {
//         return response()->json(['success' => false, 'message' => 'Pehle order select karein']);
//     }

//     $orders = FshipOrder::whereIn('id', $orderIds)->get();
//     $pickupIds = $orders->pluck('pickup_order_id')->filter()->unique()->toArray();

//     if (empty($pickupIds)) {
//         return response()->json(['success' => false, 'message' => 'Selected orders ka pickup register nahi hua hai']);
//     }

//     $processedCount = 0;
//     $errorCount = 0;
                
//     try {
//         foreach ($pickupIds as $pickupId) {
//             try {
//                 // 1. Manifest API Call
//                 $manifestResponse = $fship->generateManifest([(int)$pickupId]);

//                 // Agar API Success return karti hai
//                 if (isset($manifestResponse['status']) && $manifestResponse['status'] === "Success" && !empty($manifestResponse['shipmentData'])) {
                    
//                     $apiData = $manifestResponse['shipmentData'][0]; 
//                     $firstOrder = $orders->where('pickup_order_id', $pickupId)->first();
//                     $statusResponse = $fship->getShipmentSummary(['waybill' => $firstOrder->waybill]);
//                     $summary = $statusResponse['summary'] ?? null;
                    
//                     $rawStatus = $summary['status'] ?? 'manifested';
//                     $liveStatusSlug = strtolower(str_replace(' ', '_', $rawStatus));

//                     // 3. Table: shipment_documents Update (Success case)
//                     \DB::table('shipment_documents')->updateOrInsert(
//                         ['pickup_order_id' => (int)$pickupId],
//                         [
//                             'manifest_url'        => $apiData['manifestfile'] ?? null, 
//                             'invoice_url'         => $apiData['invoicefile'] ?? null, 
//                             'label_url'           => $apiData['labelfile'] ?? null, 
//                             'courier_name'        => $summary['fulfilledby'] ?? $firstOrder->courier_name, 
//                             'shipment_count'      => $orders->where('pickup_order_id', $pickupId)->count(), 
//                             'provider_pickup_id'  => $summary['orderid'] ?? $firstOrder->waybill, 
//                             'pickup_date'         => isset($summary['orderedon']) ? \Carbon\Carbon::parse($summary['orderedon'])->format('Y-m-d H:i:s') : now(),
//                             'remark'              => 'Success: Manifest Generated', 
//                             'last_regenerated_at' => now(), 
//                         ]
//                     );

//                     // 4. Update fship_orders (Success case)
//                     FshipOrder::whereIn('id', $orderIds) 
//                         ->where('pickup_order_id', $pickupId) 
//                         ->update([
//                             'status'     => $liveStatusSlug,
//                             'waybill'    => $summary['orderid'] ?? $firstOrder->waybill,
//                             'updated_at' => now()
//                         ]);

//                     $processedCount++;

//                 } else {
//                     // API ERROR CASE (Fship ne error message bheja)
//                     $errorMessage = $manifestResponse['message'] ?? 'Fship API failed to generate manifest';
//                     $this->handleManifestError($pickupId, $orderIds, $errorMessage);
//                     $errorCount++;
//                 }

//             } catch (\Exception $innerEx) {
//                 // Individual Pickup Loop Exception
//                 $this->handleManifestError($pickupId, $orderIds, $innerEx->getMessage());
//                 $errorCount++;
//             }
//         }

//         return response()->json([
//             'success' => $processedCount > 0,
//             'message' => "Processed: $processedCount, Errors: $errorCount. Dashboard updated."
//         ]);

//     } catch (\Exception $e) {
//         \Log::error('Bulk Manifest Global Error: ' . $e->getMessage());
//         return response()->json(['success' => false, 'message' => 'Global Error: ' . $e->getMessage()], 500);
//     }
// }

// LabelController.php - bulkManifest method

public function bulkManifest(Request $request, FshipService $fship)
{
    $orderIds = $request->input('order_ids');
    if (!$orderIds) {
        return response()->json(['success' => false, 'message' => 'Pehle order select karein']);
    }

    $orders = FshipOrder::whereIn('id', $orderIds)->get();
    $pickupIds = $orders->pluck('pickup_order_id')->filter()->unique()->toArray();

    if (empty($pickupIds)) {
        return response()->json(['success' => false, 'message' => 'Selected orders ka pickup register nahi hua hai']);
    }

    $processedCount = 0;
    $errorCount = 0;
                
    try {
        foreach ($pickupIds as $pickupId) {
            try {
                // 1. Manifest API Call
                $manifestResponse = $fship->generateManifest([(int)$pickupId]);

                // ✅ Handle BOTH response formats with SAFE DEFAULTS
                $dataToStore = null;
                $isSuccess = false;

                // 🅰️ Enhanced Format (Array Response) - YOUR RESPONSE
                if (is_array($manifestResponse) && isset($manifestResponse[0])) {
                    $apiData = $manifestResponse[0];
                    $dataToStore = [
                        // From API Response - URLs can be null if column allows
                        'manifest_url'        => $apiData['manifestFile'] ?? $apiData['manifestfile'] ?? null,
                        'invoice_url'         => $apiData['invoiceFile'] ?? $apiData['invoicefile'] ?? null,
                        'label_url'           => $apiData['labelFile'] ?? $apiData['labelfile'] ?? null,
                        
                        // Status fields - null if column allows
                        'pickup_status_id'    => $apiData['pickupStatusId'] ?? null,
                        'pickup_status'       => $apiData['pickupStatus'] ?? null,
                        
                        // ✅ FIXED: Always boolean, never null
                        'is_generated'        => isset($apiData['isGenerated']) 
                                                    ? (bool) $apiData['isGenerated'] 
                                                    : (isset($apiData['is_generated']) 
                                                        ? (bool) $apiData['is_generated'] 
                                                        : false),
                        
                        // ✅ FIXED: Valid timestamp or current time as fallback
                        'regenerate_date'     => isset($apiData['regenerateDate']) && !empty($apiData['regenerateDate'])
                                                    ? \Carbon\Carbon::parse($apiData['regenerateDate'])
                                                    : now(), // Fallback to current time
                    ];
                    $isSuccess = true;
                } 
                // 🅱️ Basic Format (Object Response from PDF docs)
                elseif (isset($manifestResponse['status']) && $manifestResponse['status'] === "Success" && !empty($manifestResponse['shipmentData'])) {
                    $apiData = $manifestResponse['shipmentData'][0];
                    $dataToStore = [
                        'manifest_url' => $apiData['manifestfile'] ?? null,
                        'invoice_url'  => $apiData['invoicefile'] ?? null,
                        'label_url'    => $apiData['labelfile'] ?? null,
                        'pickup_status_id' => null,
                        'pickup_status'    => null,
                        
                        // ✅ FIXED: Always boolean for basic format too
                        'is_generated'     => true, // Basic format implies files are generated
                        'regenerate_date'  => now(), // Set to current time
                    ];
                    $isSuccess = true;
                }

                if ($isSuccess && ($dataToStore['manifest_url'] || $dataToStore['invoice_url'] || $dataToStore['label_url'])) {
                    
                    $firstOrder = $orders->where('pickup_order_id', $pickupId)->first();
                    
                    // Get latest status if needed
                    $summary = null;
                    $liveStatusSlug = 'manifested'; // Default status
                    
                    if ($firstOrder && $firstOrder->waybill) {
                        try {
                            $statusResponse = $fship->getShipmentSummary(['waybill' => $firstOrder->waybill]);
                            $summary = $statusResponse['summary'] ?? null;
                            
                            if ($summary && isset($summary['status'])) {
                                $rawStatus = $summary['status'];
                                $liveStatusSlug = strtolower(str_replace(' ', '_', $rawStatus));
                            }
                        } catch (\Exception $e) {
                            \Log::warning('Shipment summary fetch failed: ' . $e->getMessage());
                            // Continue with default status
                        }
                    }

                    // ✅ Store ALL fields in shipment_documents with safe values
                    \DB::table('shipment_documents')->updateOrInsert(
                        ['pickup_order_id' => (int)$pickupId],
                        array_merge([
                            'courier_name'        => $summary['fulfilledby'] ?? $firstOrder->courier_name ?? null,
                            'shipment_count'      => $orders->where('pickup_order_id', $pickupId)->count(),
                            'provider_pickup_id'  => $summary['orderid'] ?? $firstOrder->waybill ?? null,
                            'pickup_date'         => isset($summary['orderedon']) 
                                                        ? \Carbon\Carbon::parse($summary['orderedon'])->format('Y-m-d H:i:s') 
                                                        : now(),
                            'remark'              => 'Success: Manifest Generated',
                            'last_regenerated_at' => now(),
                        ], $dataToStore) // Merge safe dataToStore values
                    );

                    // ✅ Update fship_orders table
                    FshipOrder::whereIn('id', $orderIds)
                        ->where('pickup_order_id', $pickupId)
                        ->update([
                            'status'     => $liveStatusSlug,
                            'updated_at' => now()
                        ]);

                    $processedCount++;

                } else {
                    // API ERROR CASE - No valid URLs received
                    $errorMessage = $manifestResponse['message'] ?? $manifestResponse['response'] ?? 'No manifest URL received';
                    $this->handleManifestError($pickupId, $orderIds, $errorMessage);
                    $errorCount++;
                }

            } catch (\Exception $innerEx) {
                $this->handleManifestError($pickupId, $orderIds, $innerEx->getMessage());
                $errorCount++;
            }
        }

        return response()->json([
            'success' => $processedCount > 0,
            'message' => "Processed: $processedCount, Errors: $errorCount. Dashboard updated."
        ]);

    } catch (\Exception $e) {
        \Log::error('Bulk Manifest Global Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Global Error: ' . $e->getMessage()], 500);
    }
}

/**
 * Sync Error ko manage karne ke liye helper function
 */
private function handleManifestError($pickupId, $selectedOrderIds, $message)
{
    // 1. shipment_documents mein error message store karein remark mein
    \DB::table('shipment_documents')->updateOrInsert(
        ['pickup_order_id' => (int)$pickupId],
        [
            'remark' => 'Sync Error: ' . substr($message, 0, 200),
            'last_regenerated_at' => now(),
        ]
    );

    // 2. fship_orders mein status 'sync_error' mark karein
    FshipOrder::whereIn('id', $selectedOrderIds)
        ->where('pickup_order_id', $pickupId)
        ->update([
            'status' => 'sync_error',
            'updated_at' => now()
        ]);

    \Log::warning("Manifest Sync Error for Pickup $pickupId: $message");
}



public function customizeManifest($pickup_order_id)
{
    $document = \App\Models\ShipmentDocument::where('pickup_order_id', $pickup_order_id)->first();
    
    if (!$document || !$document->manifest_url) {
        return back()->with('error', 'minifaes.');
    }

    try {
        $originalPdfUrl = $document->manifest_url;
        
        // Context setup to ignore SSL errors on local
        $context = stream_context_create([
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ]);

        $tempFile = tempnam(sys_get_temp_dir(), 'manifest');
        $pdfData = file_get_contents($originalPdfUrl, false, $context);
        
        if ($pdfData === false) {
            throw new \Exception("Could not download PDF from source.");
        }
        
        file_put_contents($tempFile, $pdfData);

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($tempFile);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Hide "Fship Manifest" and Write New Name
            $pdf->SetFillColor(255, 255, 255);
            $pdf->Rect(10, 8, 80, 10, 'F'); 

            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(10, 8);
            $pdf->Write(10, "Fleetshyp Manifest"); // Aapka Brand Name
        }

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Custom-Manifest-'.$pickup_order_id.'.pdf"');

    } catch (\Exception $e) {
        return "PDF editing failed: " . $e->getMessage();
    } finally {
        if (isset($tempFile) && file_exists($tempFile)) unlink($tempFile);
    }
}


public function bulkCustomizeManifest(Request $request, FshipService $fship)
{
    $ids_string = $request->get('ids'); 
    if (!$ids_string) return back()->with('error', 'plz first order select.');

    $order_ids = explode(',', $ids_string);
    $pdf = new Fpdi();
    $manifestsCount = 0;

    $context = stream_context_create(["ssl" => ["verify_peer"=>false, "verify_peer_name"=>false]]);

    try {
        foreach ($order_ids as $id) {
            $order = FshipOrder::find($id);
            if (!$order || !$order->pickup_order_id) continue;

            // 1. Check karein kya DB mein manifest already hai?
            $document = ShipmentDocument::where('pickup_order_id', $order->pickup_order_id)->first();

            // 2. 🚀 AGAR MANIFEST NAHI HAI TOH TURANT GENERATE KAREIN
            if (!$document || !$document->manifest_url) {
                $manifestResponse = $fship->generateManifest([(int)$order->pickup_order_id]);
                
                if (isset($manifestResponse['status']) && $manifestResponse['status'] === "Success") {
                    $apiData = $manifestResponse['shipmentData'][0];
                    
                    // DB mein save karein taaki agli baar API call na karni pade
                    $document = ShipmentDocument::updateOrCreate(
                        ['pickup_order_id' => $order->pickup_order_id],
                        [
                            'manifest_url' => $apiData['manifestfile'] ?? null,
                            'label_url'    => $apiData['labelfile'] ?? null,
                            'invoice_url'  => $apiData['invoicefile'] ?? null,
                            'remark'       => 'Generated during bulk download',
                            'last_regenerated_at' => now()
                        ]
                    );
                } else {
                    continue; // Agar API se bhi generate nahi hua toh is order ko skip karein
                }
            }

            // 3. Ab PDF process karein (Customization ke saath)
            if ($document && $document->manifest_url) {
                $pdfData = @file_get_contents($document->manifest_url, false, $context);
                if ($pdfData === false) continue;

                $tempFile = tempnam(sys_get_temp_dir(), 'bulk');
                file_put_contents($tempFile, $pdfData);
                $pageCount = $pdf->setSourceFile($tempFile);

                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($templateId);
                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);

                    // Branding
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->Rect(10, 8, 80, 10, 'F'); 
                    $pdf->SetFont('Arial', 'B', 16);
                    $pdf->SetXY(10, 8);
                    $pdf->Write(10, "Fleetshyp Manifest");
                }
                unlink($tempFile);
                $manifestsCount++;
            }
        }

        if ($manifestsCount === 0) {
            return back()->with('error', 'Selected The pickup for the order has not been registered.');
        }

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Bulk-Manifests-'.now()->format('dmYHi').'.pdf"');

    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}


public function downloadPicklist($ids)
{
    $orderIds = explode(',', $ids);
    
    // Orders aur unke items fetch karein
    $orders = FshipOrder::whereIn('id', $orderIds)
                ->with('items')
                ->get();

    if ($orders->isEmpty()) {
        return back()->with('error', 'No products found for selected orders.');
    }

    // PDF generate karne ke liye data prepare karein
    $pdf = Pdf::loadView('seller.leble.picklist_pdf', compact('orders'));

    // PDF settings (optional)
    $pdf->setPaper('a4', 'portrait');

    // Download response
    return $pdf->download('Picklist_' . date('d-m-Y') . '.pdf');
}

public function syncShipmentStatus(Request $request, FshipService $fship)
{
    // 1. Un orders ko lein jo final stage (delivered/cancelled) par nahi hain
    $orderIds = $request->input('order_ids');
    
    $query = FshipOrder::whereNotIn('status', ['delivered', 'cancelled', 'rto_delivered']);

    // Agar dashboard se select kiya hai toh filter lagao
    if (!empty($orderIds)) {
        $query->whereIn('id', $orderIds);
    }

    $orders = $query->get();
    $updatedCount = 0;

    foreach ($orders as $order) {
        // Waybill column check (Database Column #5)
        if (!$order->waybill) continue;

        try {
            // Fship API Call
            $statusResponse = $fship->getShipmentSummary(['waybill' => $order->waybill]);
            $summary = $statusResponse['summary'] ?? null;

            if ($summary && isset($summary['status'])) {
                $rawStatus = $summary['status']; // e.g. "In Transit"
                
                // Status Mapping: API string ko aapke dashboard slugs mein badlein
                $statusMap = [
                    'RTO Initiated' => 'rto',
                    'RTO In-Transit' => 'rto',
                    'RTO Delivered' => 'rto_delivered',
                    'Undelivered'   => 'undelivered',
                    'Exception'     => 'exception',
                    'Delivered'     => 'delivered',
                    'Out For Delivery' => 'out_for_delivery',
                    'In Transit'    => 'in_transit'
                ];

                $liveStatusSlug = $statusMap[$rawStatus] ?? strtolower(str_replace(' ', '_', $rawStatus));

                // 2. fship_orders table update (Column #45 aur #47)
                $order->update([
                    'status'     => $liveStatusSlug,
                    'updated_at' => now()
                ]);

                // 3. shipment_documents table mein Remark update (Error handle karne ke liye)
                \DB::table('shipment_documents')
                    ->where('pickup_order_id', $order->pickup_order_id) // Match Column #4
                    ->update([
                        'remark' => 'Last Sync: ' . $rawStatus,
                        'last_regenerated_at' => now()
                    ]);

                $updatedCount++;
            }
        } catch (\Exception $e) {
            \Log::error("Status Sync Failed for Waybill $order->waybill: " . $e->getMessage());
        }
    }

    return response()->json([
        'success' => true,
        'message' => "$updatedCount orders ka live status sync ho gaya hai."
    ]);
}

}