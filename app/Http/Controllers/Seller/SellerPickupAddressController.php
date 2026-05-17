<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\PickupAddress;
use App\Services\FshipService;
use App\Models\VendorAddress;
use App\Models\RtoAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class SellerPickupAddressController extends Controller
{
    /**
     * Display a listing of pickup addresses.
     */
public function index(Request $request)
{
    $userId = Auth::id();

    $query = PickupAddress::where('user_id', $userId)
                ->whereNull('deleted_at'); 

      
                
    // 🔎 Address Name Filter
    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where('warehouse_name', 'LIKE', "%{$search}%");
    }

    // 👤 Contact Name Filter
    if ($request->filled('contact')) {

        $contact = trim($request->contact);

        $query->where('contact_name', 'LIKE', "%{$contact}%");
    }

    // 🔑 Keyword Filter
    if ($request->filled('keyword')) {

        $keyword = trim($request->keyword);

        $query->where(function ($q) use ($keyword) {

            $q->where('city', 'LIKE', "%{$keyword}%")
              ->orWhere('pincode', 'LIKE', "%{$keyword}%")
              ->orWhere('address_line1', 'LIKE', "%{$keyword}%")
              
              // 🔥 NULL safe condition
              ->orWhere(function($sub) use ($keyword) {
                    $sub->whereNotNull('address_line2')
                        ->where('address_line2', 'LIKE', "%{$keyword}%");
              })

              ->orWhere('warehouse_name', 'LIKE', "%{$keyword}%")
              ->orWhere('contact_name', 'LIKE', "%{$keyword}%")
              ->orWhere('phone_number', 'LIKE', "%{$keyword}%")
              ->orWhere('email', 'LIKE', "%{$keyword}%");
        });
    }
    
    $warehouses = $query
        ->latest()
        ->paginate(50)
        ->withQueryString();

    return view('seller.addWhereHouse.index', compact('warehouses'));
}

public function edit($id)
{
    $warehouse = PickupAddress::with(['vendorAddress', 'rto'])
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->first();

    if (!$warehouse) {
        return response()->json(['success' => false, 'message' => 'Warehouse not found'], 404);
    }

    return response()->json($warehouse);
}

public function store(Request $request, FshipService $fship)
{
    //dd($request->all());
    $userId = Auth::id();
    $validator = Validator::make($request->all(), [
        'warehouseName' => "required|string|max:255|unique:pickup_addresses,warehouse_name,NULL,id,user_id,$userId",
        'contactName'   => 'required|string|max:255',
        'phoneNumber'   => 'required|digits:10',
        'email'         => 'required|email|max:255',
        'addressLine1'  => 'required|string|max:500',
        'addressLine2'  => 'nullable|string|max:500',
        'pincode'       => 'required|digits:6',
        'city'          => 'required|string|max:100',
        'stateId'       => 'required|integer',
        'countryId'     => 'required|integer|in:1',

        'is_vendor'     => 'nullable|in:on',
        'vendor_name'   => 'nullable|required_if:is_vendor,on|string|max:255',
        'vendor_gstin'  => 'nullable|required_if:is_vendor,on|string|max:20',

        'is_rto'        => 'nullable|in:on',
        'rto_nick_name'     => 'nullable|required_if:is_rto,on|string|max:255',
        'rto_contact_name'  => 'nullable|required_if:is_rto,on|string|max:255',
        'rto_phone'         => 'nullable|required_if:is_rto,on|digits:10',
        'rto_email'         => 'nullable|required_if:is_rto,on|email|max:255',
        'rto_address'       => 'nullable|required_if:is_rto,on|string|max:500'
    ]);
   // dd($request->all());
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $data = $validator->validated();

    DB::beginTransaction();

    try {
        /* ============================================================
           1. FSHIP API PAYLOAD (Strict PascalCase Fix) 
           ============================================================ */
        $apiPayload = [
            'warehouseId' => 0,
            'WarehouseName' => $data['warehouseName'],
            'ContactName'   => $data['contactName'],
            'AddressLine1'  => $data['addressLine1'],
            'AddressLine2'  => $data['addressLine2'] ?? '',
            'Pincode'       => $data['pincode'],
            'City'          => $data['city'],
            'StateId'       => (int)$data['stateId'],
            'CountryId'     => (int)$data['countryId'],
            'PhoneNumber'   => $data['phoneNumber'],
            'Email'         => $data['email'],
        ];
       //dd($apiPayload);
        $response = $fship->addWarehouse($apiPayload);
      //  dd($response);
        if (!$response->successful()) {
            // API error return karti hai toh use properly throw karein
            $errorData = $response->json();
            throw new \Exception($errorData['message'] ?? $errorData['title'] ?? "Fship API Error");
        }

        $apiData = $response->json();
       // dd($apiData);
        // Fship system unique ID 'warehouseId' deta hai
        $fshipWarehouseId = $apiData['warehouseId'] ?? $apiData['id'] ?? null;

        if (!$fshipWarehouseId) {
            throw new \Exception("Fship API did not return a valid warehouse ID.");
        }

        /* ============================================================
           2. SAVE PICKUP ADDRESS (Match DB Column Case)
           ============================================================ */
        $pickup = PickupAddress::create([
            'user_id'            => $userId,
            'warehouse_name'     => $data['warehouseName'],
            'contact_name'       => $data['contactName'],
            'phone_number'       => $data['phoneNumber'],
            'email'              => $data['email'],
            'address_line1'      => $data['addressLine1'],
            'address_line2'      => $data['addressLine2'],
            'pincode'            => $data['pincode'],
            'city'               => $data['city'],
            'state_id'           => $data['stateId'],
            'country_id'         => $data['countryId'],
            'pick_address_ID'    => $fshipWarehouseId, // Fixed column name case
            'is_default'         => 0,
        ]);

        /* ============================================================
           3. CONDITIONAL ADDRESSES
           ============================================================ */
        if ($request->get('is_vendor') === 'on') {
            $pickup->vendorAddress()->create([
                'pick_address_ID'   => $fshipWarehouseId,
                'vendor_name'       => $data['vendor_name'],
                'vendor_gstin'      => $data['vendor_gstin'],
            ]);
        }
       // dd($request->all());
       if ($request->get('is_rto') === 'on') {
               $pickup->rto()->create([
                   'pick_address_id' => $fshipWarehouseId,
                   'rto_nick_name'   => $data['rto_nick_name'],
                   'contact_name'    => $data['rto_contact_name'],
                   'phone'           => $data['rto_phone'],
                   'email'           => $data['rto_email'],
                   'address_line1'   => $data['rto_address'],
                   'pincode'         => $data['pincode'],
                   'city'            => $data['city'],
                   'state_id'        => $data['stateId'],
                  'country_id'      => $data['countryId'],
              ]);
         }

        DB::commit();
      //  dd($request->all());
        return back()->with('success', 'Pickup Address added successfully!');

    } catch (\Throwable $e) {
       // dd($e->getMessage());
        DB::rollBack();
        \Illuminate\Support\Facades\Log::error('Fship Warehouse Error: ' . $e->getMessage());
        return back()->with('error', $e->getMessage())->withInput();
    }
}


    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pickup_address_template.csv"',
        ];

        $columns = [
            'Warehouse Name',
            'Contact Name',
            'Phone Number',
            'Alternate Phone Number',
            'Email Address',
            'Address Line 1',
            'Address Line 2',
            'Pincode',
            'City',
            'State ID',
            'Country ID',
            'Is Primary (0 or 1)'
        ];

        $dummyData = [
            'Main Warehouse',
            'John Doe',
            '9876543210',
            '9876543211',
            'john@example.com',
            'Plot No. 123, Sector 4',
            'Near City Mall',
            '110001',
            'New Delhi',
            '1',
            '1',
            '1'
        ];

        $callback = function() use ($columns, $dummyData) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel
            fputcsv($file, $columns);
            fputcsv($file, $dummyData);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
public function setPrimary(Request $request)
{
    
    $id = $request->id;
    if (!$id) {
        return response()->json(['success' => false, 'message' => 'ID is required']);
    }

  
    $warehouse = PickupAddress::where('id', $id)
                               ->where('user_id', Auth::id())
                               ->first();

    if (!$warehouse) {
        return response()->json(['success' => false, 'message' => 'Warehouse not found']);
    }

   
    DB::transaction(function () use ($warehouse) {
        
        PickupAddress::where('user_id', Auth::id())->update(['is_default' => 0]);
        $warehouse->update(['is_default' => 1]);
    });

    return response()->json(['success' => true, 'message' => 'Primary address updated!']);
}

// Data update karne ke liye
public function update(Request $request, $id, FshipService $fship) {
    $userId = Auth::id();
    
    // 1. Validation sahi karein
    $validated = $request->validate([
        'warehouseName' => "required|string|max:255|unique:pickup_addresses,warehouse_name,$id,id,user_id,$userId",
        'contactName'   => 'required|string|max:255',
        'addressLine1'  => 'required|string',
        'addressLine2'  => 'nullable|string',
        'phoneNumber'   => 'required|digits:10',
        'email'         => 'required|email',
        // Optional sections
        'vendor_name'   => 'nullable|string',
        'vendor_gstin'  => 'nullable|string',
        'rto_nick_name' => 'nullable|string',
    ]);

    DB::beginTransaction();
    try {
        $wh = PickupAddress::where('user_id', $userId)->findOrFail($id);

        // 2. FShip API Update Call (As per Doc Page 7)
        $apiPayload = [
            'warehouseId'   => (int)$wh->fship_warehouse_id, // Purana ID
            'warehouseName' => $request->warehouseName,
            'contactName'   => $request->contactName,
            'addressLine1'  => $request->addressLine1,
            'addressLine2'  => $request->addressLine2 ?? '',
            'pincode'       => $wh->pincode, // Pincode update nahi hota aksar
            'city'          => $wh->city,
            'stateId'       => (int)$wh->state_id,
            'countryId'     => (int)$wh->country_id,
            'phoneNumber'   => $request->phoneNumber,
            'email'         => $request->email,
        ];

        $response = $fship->updateWarehouse($apiPayload); // Service mein updateWarehouse function hona chahiye

        if (!$response->successful()) {
            throw new \Exception('FShip API Update Failed: ' . ($response->json()['response'] ?? 'Unknown Error'));
        }

        // 3. Update Local Pickup Table
        $wh->update([
            'warehouse_name' => $request->warehouseName,
            'contact_name'   => $request->contactName,
            'address_line1'  => $request->addressLine1,
            'address_line2'  => $request->addressLine2,
            'phone_number'   => $request->phoneNumber,
            'email'          => $request->email,
        ]);

        // 4. Update/Create RTO Table
        if($request->filled('rto_nick_name')) {
            $wh->rto()->updateOrCreate(['pickup_address_id' => $wh->id], [
                'rto_nick_name' => $request->rto_nick_name,
                'contact_name'  => $request->rto_contact_name,
                'phone'         => $request->rto_phone,
                'email'         => $request->rto_email,
                'address_line1' => $request->rto_address,
            ]);
        }

        // 5. Update/Create Vendor Table
        if($request->filled('vendor_name')) {
            $wh->vendorAddress()->updateOrCreate(['pickup_address_id' => $wh->id], [
                'vendor_name'  => $request->vendor_name,
                'vendor_gstin' => $request->vendor_gstin,
            ]);
        }

        DB::commit();
        return back()->with('success', 'Details updated successfully in system & FShip! 🚀');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage())->withInput();
    }
  }
}