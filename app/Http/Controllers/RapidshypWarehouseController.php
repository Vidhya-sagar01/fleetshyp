<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\RapidShypService;
use App\Models\RapidshypWarehouse;
use App\Models\RapidshypRtoAddress;



class RapidshypWarehouseController extends Controller
{
    protected $rapidShypService;

    public function __construct(RapidShypService $rapidShypService)
    {
        $this->rapidShypService = $rapidShypService;
    }

    // ================================================================
    // INDEX
    // ================================================================
    public function index()
    {
        $warehouses = RapidshypWarehouse::where('seller_id', auth()->id())
            ->orderBy('is_primary', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
       // dd($warehouses);
        return view('seller.rapidshypWarehouse.rapidshypWarehouse', compact('warehouses'));
    }


    public function store(Request $request)
{
    DB::beginTransaction();
      
    try {
        $sellerId = auth()->id();
        $useRTO   = $request->boolean('use_alt_rto_address');

        // ---- Validate ----
        $validated = $request->validate(
            $this->buildValidationRules($useRTO, $request, $sellerId),
            $this->validationMessages()
        );

        // ---- Build API payload ----
        $apiPayload = $this->buildApiPayload($request, $useRTO);
       // dd($apiPayload);
        // ---- Call RapidShyp API ----
        $apiResponse = $this->rapidShypService->addWarehouse($apiPayload);
          //dd($apiResponse);
        // ✅ Extract API response data from 'body'
        $apiBody = $apiResponse['body'] ?? $apiResponse;
        
        if (
            !isset($apiBody['status']) ||
            strtolower($apiBody['status']) !== 'success'
        ) {
            DB::rollBack();
            return back()
                ->with('error', $apiBody['remark'] ?? $apiResponse['message'] ?? 'RapidShyp API failed to create pickup location')
                ->withInput();
        }

        // ✅ Extract values from API response
        $pickupLocationName = $apiBody['pickup_location_name'] ?? null;  // "Lavinia Hansen"
        $rtoLocationName    = $apiBody['rto_location_name'] ?? null;     // "hgjhgjg"

        // ---- Handle RTO ----
        $rtoAddressId = $this->handleRtoStore($request, $sellerId, $useRTO, $apiResponse);
       // dd($rtoAddressId);
        // ---- Save warehouse ----
        RapidshypWarehouse::create([
            'seller_id'              => $sellerId,
            'warehouse_name'         => $validated['address_name'],
            'contact_person'         => $validated['contact_name'],
            'contact_number'         => $this->cleanPhone($validated['contact_number']),
            'email_id'               => $validated['email'] ?? null,
            'address_line_1'         => $validated['address_line'],
            'address_line_2'         => $validated['address_line2'] ?? null,
            'pincode'                => $validated['pincode'],
            'city'                   => $request->city    ?: null,
            'state'                  => $request->state   ?: null,
            'country'                => $request->country ?: 'INDIA',
            'gstin'                  => $request->gstin ? strtoupper($request->gstin) : null,
            'latitude'               => $request->filled('latitude')  ? (float) $request->latitude  : null,
            'longitude'              => $request->filled('longitude') ? (float) $request->longitude : null,
            'warehousing_system'     => $request->warehousing_system ?? null,
            'dropship_location'      => $request->boolean('dropship_location'),
            
            // ✅ Boolean flag - kya RTO use ho raha hai?
            'use_alt_rto_address'    => $useRTO ? 1 : 0,
            
            // ✅ RTO related
            'rto_address_id'         => $rtoAddressId,
            'rto_location_name'      => $rtoLocationName,     // 🎯 NEW COLUMN (if added)
            
            // ✅ Pickup location from API
            'rapidshyp_warehouse_id' => $pickupLocationName,  // "Lavinia Hansen"
            
            'is_primary'             => false,
        ]);
       
        DB::commit();
        return back()->with('success', 'Pickup address created successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return back()
            ->withErrors($e->validator)
            ->withInput()
            ->with('error', 'Please fix the validation errors below.');

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();
        dd($e->getMessage());
        Log::error('DB Error - Warehouse Store', [
            'message'      => $e->getMessage(),
            'seller_id'    => auth()->id(),
        ]);
        return back()->with('error', 'Database error occurred. Please try again.')->withInput();

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error - Warehouse Store', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile() . ':' . $e->getLine(),
        ]);
        return back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
    }
}


    // ================================================================
    // EDIT — returns JSON for modal
    // ================================================================
    public function edit($id)
    {
      
        try {
            $warehouse = RapidshypWarehouse::where('id', $id)
                ->where('seller_id', auth()->id())
                ->firstOrFail();

            // Map DB columns → blade field names so JS can fill inputs directly
            $data = [
                'id'                  => $warehouse->id,
                // Pickup — blade input names
                'address_name'        => $warehouse->warehouse_name,
                'contact_name'        => $warehouse->contact_person,
                'contact_number'      => $warehouse->contact_number,
                'email'               => $warehouse->email_id,
                'address_line'        => $warehouse->address_line_1,
                'address_line2'       => $warehouse->address_line_2,
                'pincode'             => $warehouse->pincode,
                'city'                => $warehouse->city,
                'state'               => $warehouse->state,
                'country'             => $warehouse->country ?? 'INDIA',
                'gstin'               => $warehouse->gstin,
                'latitude'            => $warehouse->latitude,
                'longitude'           => $warehouse->longitude,
                'warehousing_system'  => $warehouse->warehousing_system,
                'dropship_location'   => (bool) $warehouse->dropship_location,
                'use_alt_rto_address' => (bool) $warehouse->use_alt_rto_address,
                'is_primary'          => (bool) $warehouse->is_primary,
                // RTO — will be filled below if present
                'rto_warehouse_id'    => null,
            ];

            // RTO data
            if ($warehouse->use_alt_rto_address) {
                // Case 1: mapped to an existing warehouse (rto_address_id points to a warehouse)
                if ($warehouse->rto_address_id && !$warehouse->rtoAddress) {
                    $data['rto_warehouse_id'] = $warehouse->rto_address_id;
                }

                // Case 2: has a dedicated RTO address record
                if ($warehouse->rtoAddress) {
                    $rto = $warehouse->rtoAddress;
                    $data['rto_address_name']   = $rto->rto_address_name;   // blade: rto_address_name
                    $data['rto_contact_name']   = $rto->rto_contact_name;   // blade: rto_contact_name
                    $data['rto_contact_number'] = $rto->rto_contact_number;
                    $data['rto_email']          = $rto->rto_email;
                    $data['rto_address_line']   = $rto->rto_address_line;   // blade: rto_address_line
                    $data['rto_address_line2']  = $rto->rto_address_line2;  // blade: rto_address_line2
                    $data['rto_pincode']        = $rto->rto_pincode;
                    $data['rto_city']           = $rto->rto_city;
                    $data['rto_state']          = $rto->rto_state;
                    $data['rto_country']        = $rto->rto_country ?? 'INDIA';
                    $data['rto_gstin']          = $rto->rto_gstin;
                }
            }

            return response()->json($data);

        } catch (\Exception $e) {
            Log::error('Warehouse Edit Error', ['message' => $e->getMessage(), 'id' => $id]);
            return response()->json(['error' => 'Warehouse not found'], 404);
        }
    }

    // ================================================================
    // UPDATE
    // ================================================================
    public function update(Request $request, $id)
    {

        $warehouse = RapidshypWarehouse::where('id', $id)
            ->where('seller_id', auth()->id())
            ->firstOrFail();
      
        $useRTO = $request->boolean('use_alt_rto_address');

        // ---- Validate ----
        $validated = $request->validate(
            $this->buildValidationRules($useRTO, $request, $warehouse->seller_id),
            $this->validationMessages()
        );
        DB::beginTransaction();

        try {
            $sellerId = auth()->id();

            $warehouse = RapidshypWarehouse::where('id', $id)
                ->where('seller_id', $sellerId)
                ->firstOrFail();

            $useRTO = $request->boolean('use_alt_rto_address');

            // ---- Validate ----
            $validated = $request->validate(
                $this->buildValidationRules($useRTO, $request, $sellerId),
                $this->validationMessages()
            );

            // ---- Build API payload ----
            $apiPayload = $this->buildApiPayload($request, $useRTO);

            // ---- Call RapidShyp update API (if supported) ----
            // Uncomment when RapidShyp provides an update endpoint:
            // $apiResponse = $this->rapidShypService->updateWarehouse(
            //     $warehouse->rapidshyp_warehouse_id, $apiPayload
            // );
            // if (!isset($apiResponse['status']) || strtolower($apiResponse['status']) !== 'success') {
            //     DB::rollBack();
            //     return back()->with('error', $apiResponse['remark'] ?? 'RapidShyp API update failed')->withInput();
            // }

            // ---- Handle RTO update ----
            $rtoAddressId = $this->handleRtoUpdate($request, $sellerId, $useRTO, $warehouse);

            // ---- Update warehouse ----
            $warehouse->update([
                'warehouse_name'      => $validated['address_name'],
                'contact_person'      => $validated['contact_name'],
                'contact_number'      => $this->cleanPhone($validated['contact_number']),
                'email_id'            => $validated['email'] ?? null,
                'address_line_1'      => $validated['address_line'],
                'address_line_2'      => $validated['address_line2'] ?? null,
                'pincode'             => $validated['pincode'],
                'city'                => $request->city    ?: null,
                'state'               => $request->state   ?: null,
                'country'             => $request->country ?: 'INDIA',
                'gstin'               => $request->gstin ? strtoupper($request->gstin) : null,
                'latitude'            => $request->filled('latitude')  ? (float) $request->latitude  : null,
                'longitude'           => $request->filled('longitude') ? (float) $request->longitude : null,
                'warehousing_system'  => $request->warehousing_system ?? null,
                'dropship_location'   => $request->boolean('dropship_location'),
                'use_alt_rto_address' => $useRTO,
                'rto_address_id'      => $rtoAddressId,
            ]);

            DB::commit();
            return back()->with('success', 'Pickup address updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput()
                ->with('error', 'Please fix the validation errors below.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Warehouse Update Error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile() . ':' . $e->getLine(),
                'id'      => $id,
            ]);
            return back()->with('error', 'Update failed. Please try again.')->withInput();
        }
    }

    // ================================================================
    // SET PRIMARY
    // ================================================================


    public function setPrimary(Request $request, $id)
    {

   // dd($request->all(), $id);
        // ✅ Step 0: Validate route parameter manually (not from request body)
        if (!is_numeric($id) || (int) $id < 1) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Invalid warehouse ID'], 400)
                : back()->with('error', 'Invalid warehouse ID.');
        }

        $warehouseId = (int) $id;
        $sellerId = auth()->id();
        //dd($sellerId);
        // dd($warehouseId);
        // ✅ Step 1: Check authentication
        if (!$sellerId) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Unauthorized'], 401)
                : back()->with('error', 'Please login first.');
        }

        try {
            DB::transaction(function () use ($sellerId, $warehouseId) {
                
                // ✅ Step 2: Sabhi warehouses ko non-primary banao (same seller ke liye)
                RapidshypWarehouse::where('seller_id', $sellerId)
                    ->update(['is_primary' => 0]);
            
                // ✅ Step 3: Sirf selected warehouse ko primary banao
                // Security: seller_id check ensures user apna hi warehouse update kar sake
                $updated = RapidshypWarehouse::where('id', $warehouseId)
                    ->where('seller_id', $sellerId)
                    ->update(['is_primary' => 1]);

                // ✅ Step 4: Verify update hua ya nahi
                if ($updated === 0) {
                    throw new \Illuminate\Database\Eloquent\ModelNotFoundException(
                        "Warehouse #{$warehouseId} not found for seller #{$sellerId}"
                    );
                }
            });

            // ✅ Success Response - AJAX/Fetch (Razorpay/JS calls)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '✅ Primary address updated successfully!',
                    'data' => [
                        'warehouse_id' => $warehouseId,
                        'seller_id' => $sellerId
                    ]
                ], 200);
            }

            // ✅ Success Response - Normal Form Submit
            return back()->with('success', '✅ Primary pickup address updated successfully!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // ❌ Warehouse not found or access denied
            Log::warning('Set Primary: Warehouse not found', [
                'warehouse_id' => $warehouseId,
                'seller_id' => $sellerId,
                'ip' => $request->ip()
            ]);

            return $request->ajax()
                ? response()->json([
                    'success' => false,
                    'message' => 'Address not found or access denied.',
                    'error_code' => 'WAREHOUSE_NOT_FOUND'
                ], 404)
                : back()->with('error', 'Address not found or you do not have permission.');

        } catch (\Illuminate\Database\QueryException $e) {
            // ❌ Database error
            Log::error('Set Primary: Database error', [
                'message' => $e->getMessage(),
                'warehouse_id' => $warehouseId,
                'seller_id' => $sellerId
            ]);

            return $request->ajax()
                ? response()->json([
                    'success' => false,
                    'message' => 'Database error. Please try again.',
                    'error_code' => 'DB_ERROR'
                ], 500)
                : back()->with('error', 'Database error. Please try again.');

        } catch (\Exception $e) {
            // ❌ Generic error
            Log::error('Set Primary: Unexpected error', [
                'message' => $e->getMessage(),
                'warehouse_id' => $warehouseId,
                'seller_id' => $sellerId,
                'trace' => $e->getTraceAsString()
            ]);

            return $request->ajax()
                ? response()->json([
                    'success' => false,
                    'message' => 'Failed to update primary address. Please try again.',
                    'error_code' => 'INTERNAL_ERROR'
                ], 500)
                : back()->with('error', 'Failed to set primary address. Please try again.');
        }
    }





    // ================================================================
    // DESTROY
    // ================================================================
    public function destroy($id)
    {
        try {
            $sellerId  = auth()->id();
            $warehouse = RapidshypWarehouse::where('id', $id)
                ->where('seller_id', $sellerId)
                ->firstOrFail();

            // Don't allow deleting the only primary address
            if (
                $warehouse->is_primary &&
                RapidshypWarehouse::where('seller_id', $sellerId)->count() === 1
            ) {
                return back()->with('error', 'Cannot delete the only primary pickup address.');
            }

            // Optional: call RapidShyp delete API
            // $this->rapidShypService->deleteWarehouse($warehouse->rapidshyp_warehouse_id);

            // Delete associated RTO record too (if dedicated, not a mapped warehouse)
            if ($warehouse->rtoAddress) {
                $warehouse->rtoAddress->delete();
            }

            $warehouse->delete();

            return back()->with('success', 'Pickup address deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Warehouse Delete Error', ['message' => $e->getMessage(), 'id' => $id]);
            return back()->with('error', 'Delete failed. Please try again.');
        }
    }

  
    private function buildValidationRules(bool $useRTO, Request $request, int $sellerId): array
    {
        $rules = [
            // ---- Pickup — exact blade input name="..." field names ----
            'address_name'   => 'required|string|min:3|max:75',
            'contact_name'   => ['required', 'string', 'regex:/^[A-Za-z\s]+$/'],
            'contact_number' => ['required', 'digits:10', 'regex:/^[6-9][0-9]{9}$/'],
            'email'          => 'nullable|email|max:255',
            'address_line'   => 'required|string|min:3|max:100',
            // address_line2: optional — skip min:3 when empty string is submitted
            'address_line2'  => 'nullable|string|max:100|min:3',
            'pincode'        => ['required', 'digits:6'],
            // city/state/country: auto-filled readonly fields — just accept what comes
            'city'           => 'nullable|string|max:100',
            'state'          => 'nullable|string|max:100',
            'country'        => 'nullable|string|max:100',
            'gstin'          => ['nullable', 'string', 'regex:/^[0-9]{2}[A-Z]{5}[A-Z0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'],
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',
            'warehousing_system' => 'nullable|in:own,third_party',
            'dropship_location'  => 'nullable|boolean',
        ];

        if ($useRTO) {
            // Blade sends name="rto_address" (select) when using existing warehouse
            if ($request->filled('rto_address')) {
                $rules['rto_address'] = 'required|exists:rapidshyp_warehouses,id,seller_id,' . $sellerId;
            } else {
                // New RTO address — blade sends rto_address_name, rto_contact_name, etc.
                $rules = array_merge($rules, [
                    'rto_address_name'   => 'required|string|min:3|max:75',
                    'rto_contact_name'   => ['required', 'string', 'regex:/^[A-Za-z\s]+$/'],
                    'rto_contact_number' => ['required', 'digits:10', 'regex:/^[6-9][0-9]{9}$/'],
                    'rto_email'          => 'nullable|email|max:255',
                    'rto_address_line'   => 'required|string|min:3|max:100',
                    'rto_address_line2'  => 'nullable|string|max:100|min:3',
                    'rto_pincode'        => ['required', 'digits:6'],
                    'rto_city'           => 'nullable|string|max:100',
                    'rto_state'          => 'nullable|string|max:100',
                    'rto_country'        => 'nullable|string|max:100',
                    'rto_gstin'          => ['nullable', 'string', 'regex:/^[0-9]{2}[A-Z]{5}[A-Z0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'],
                ]);
            }
        }

        return $rules;
    }

    /**
     * Custom validation error messages.
     */
    private function validationMessages(): array
    {
        return [
            'address_name.required'      => 'Address name is required.',
            'address_name.min'           => 'Address name must be at least 3 characters.',
            'address_name.max'           => 'Address name cannot exceed 75 characters.',
            'contact_name.required'      => 'Contact name is required.',
            'contact_name.regex'         => 'Contact name can only contain alphabets and spaces.',
            'contact_number.required'    => 'Contact number is required.',
            'contact_number.digits'      => 'Contact number must be exactly 10 digits.',
            'contact_number.regex'       => 'Phone number must start with 6, 7, 8 or 9.',
            'email.email'                => 'Please enter a valid email address.',
            'address_line.required'      => 'Address line 1 is required.',
            'address_line.min'           => 'Address line 1 must be at least 3 characters.',
            'address_line.max'           => 'Address line 1 cannot exceed 100 characters.',
            'address_line2.min'          => 'Address line 2 must be at least 3 characters if entered.',
            'address_line2.max'          => 'Address line 2 cannot exceed 100 characters.',
            'pincode.required'           => 'Pincode is required.',
            'pincode.digits'             => 'Pincode must be exactly 6 digits.',
            'gstin.regex'                => 'Enter a valid GSTIN format (e.g. 24AAACO4716C1ZZ).',

            'rto_address.required'       => 'Please select an RTO address.',
            'rto_address.exists'         => 'Selected RTO address is invalid.',
            'rto_address_name.required'  => 'RTO address name is required.',
            'rto_address_name.min'       => 'RTO address name must be at least 3 characters.',
            'rto_address_name.max'       => 'RTO address name cannot exceed 75 characters.',
            'rto_contact_name.required'  => 'RTO contact name is required.',
            'rto_contact_name.regex'     => 'RTO contact name can only contain alphabets and spaces.',
            'rto_contact_number.required'=> 'RTO contact number is required.',
            'rto_contact_number.digits'       => 'RTO contact number must be exactly 10 digits.',
            'rto_contact_number.regex'        => 'RTO phone number must start with 6, 7, 8 or 9.',
            'rto_email.email'            => 'Please enter a valid RTO email address.',
            'rto_address_line.required'  => 'RTO address line 1 is required.',
            'rto_address_line.min'       => 'RTO address line 1 must be at least 3 characters.',
            'rto_address_line.max'       => 'RTO address line 1 cannot exceed 100 characters.',
            'rto_address_line2.min'      => 'RTO address line 2 must be at least 3 characters if entered.',
            'rto_address_line2.max'      => 'RTO address line 2 cannot exceed 100 characters.',
            'rto_pincode.required'       => 'RTO pincode is required.',
            'rto_pincode.digits'              => 'RTO pincode must be exactly 6 digits.',
            'rto_gstin.regex'            => 'Enter a valid RTO GSTIN format.',
        ];
    }

 
    private function buildApiPayload(Request $request, bool $useRTO): array
    {
        $payload = [
            'address_name'        => substr(trim($request->address_name), 0, 75),
            'contact_name'        => trim($request->contact_name),
            'contact_number'      => $this->cleanPhone($request->contact_number),
            'email'               => $request->filled('email') ? strtolower(trim($request->email)) : null,
            'address_line'        => trim($request->address_line),
            'address_line2'       => $request->filled('address_line2') ? trim($request->address_line2) : '',
            'pincode'             => $request->pincode,
            'gstin'               => $request->filled('gstin') ? strtoupper(trim($request->gstin)) : null,
            'dropship_location'   => $request->boolean('dropship_location'),
            'use_alt_rto_address' => $useRTO,
        ];

        if ($useRTO) {
            if ($request->filled('rto_address')) {
                // Existing warehouse mapped as RTO
                $payload['rto_address'] = (string) $request->rto_address;
            } else {
                // New RTO address object — exact API field names
                $payload['create_rto_address'] = [
                    'rto_address_name'   => substr(trim($request->rto_address_name), 0, 75),
                    'rto_contact_name'   => trim($request->rto_contact_name),
                    'rto_contact_number' => $this->cleanPhone($request->rto_contact_number),
                    'rto_email'          => $request->filled('rto_email') ? strtolower(trim($request->rto_email)) : null,
                    'rto_address_line'   => trim($request->rto_address_line),
                    'rto_address_line2'  => $request->filled('rto_address_line2') ? trim($request->rto_address_line2) : '',
                    'rto_pincode'        => $request->rto_pincode,
                    'rto_gstin'          => $request->filled('rto_gstin') ? strtoupper(trim($request->rto_gstin)) : null,
                ];
            }
        }

        return $payload;
    }

    /**
     * Handle RTO creation on store().
     * Returns rto_address_id to store in warehouse row, or null.
     */
    private function handleRtoStore(Request $request, int $sellerId, bool $useRTO, array $apiResponse): ?int
    {
        if (!$useRTO) return null;

        // Mapped to an existing warehouse
        if ($request->filled('rto_address')) {
            return (int) $request->rto_address;
        }

        // Create a new RTO address record
        $rto = RapidshypRtoAddress::create([
            'seller_id'          => $sellerId,
            'rto_address_name'   => $request->rto_address_name,
            'rto_contact_name'   => $request->rto_contact_name,
            'rto_contact_number' => $this->cleanPhone($request->rto_contact_number),
            'rto_email'          => $request->rto_email ?? null,
            'rto_address_line'   => $request->rto_address_line,
            'rto_address_line2'  => $request->rto_address_line2 ?? null,
            'rto_pincode'        => $request->rto_pincode,
            'rto_city'           => $request->rto_city,
            'rto_state'          => $request->rto_state,
            'rto_country'        => $request->rto_country ?? 'INDIA',
            'rto_gstin'          => $request->filled('rto_gstin') ? strtoupper($request->rto_gstin) : null,
            // API response returns rto_location_name (not an id), store for reference
            'rapidshyp_rto_name' => $apiResponse['rto_location_name'] ?? null,
        ]);

        return $rto->id;
    }

    /**
     * Handle RTO update / create on update().
     * Returns rto_address_id or null.
     */
    private function handleRtoUpdate(Request $request, int $sellerId, bool $useRTO, RapidshypWarehouse $warehouse): ?int
    {
        if (!$useRTO) {
            // RTO disabled — delete old dedicated RTO record if exists
            if ($warehouse->rtoAddress) {
                $warehouse->rtoAddress->delete();
            }
            return null;
        }

        // Mapped to an existing warehouse
        if ($request->filled('rto_address')) {
            // If there was a dedicated RTO record before, delete it
            if ($warehouse->rtoAddress && $warehouse->rto_address_id !== (int) $request->rto_address) {
                $warehouse->rtoAddress->delete();
            }
            return (int) $request->rto_address;
        }

        // Update existing RTO record
        if ($warehouse->rtoAddress) {
            $warehouse->rtoAddress->update([
                'rto_address_name'   => $request->rto_address_name,
                'rto_contact_name'   => $request->rto_contact_name,
                'rto_contact_number' => $this->cleanPhone($request->rto_contact_number),
                'rto_email'          => $request->rto_email ?? null,
                'rto_address_line'   => $request->rto_address_line,
                'rto_address_line2'  => $request->rto_address_line2 ?? null,
                'rto_pincode'        => $request->rto_pincode,
                'rto_city'           => $request->rto_city,
                'rto_state'          => $request->rto_state,
                'rto_country'        => $request->rto_country ?? 'INDIA',
                'rto_gstin'          => $request->filled('rto_gstin') ? strtoupper($request->rto_gstin) : null,
            ]);
            return $warehouse->rtoAddress->id;
        }

        // No RTO record exists yet — create one
        $rto = RapidshypRtoAddress::create([
            'seller_id'          => $sellerId,
            'rto_address_name'   => $request->rto_address_name,
            'rto_contact_name'   => $request->rto_contact_name,
            'rto_contact_number' => $this->cleanPhone($request->rto_contact_number),
            'rto_email'          => $request->rto_email ?? null,
            'rto_address_line'   => $request->rto_address_line,
            'rto_address_line2'  => $request->rto_address_line2 ?? null,
            'rto_pincode'        => $request->rto_pincode,
            'rto_city'           => $request->rto_city,
            'rto_state'          => $request->rto_state,
            'rto_country'        => $request->rto_country ?? 'INDIA',
            'rto_gstin'          => $request->filled('rto_gstin') ? strtoupper($request->rto_gstin) : null,
        ]);

        return $rto->id;
    }

    /**
     * Strip non-digits, take last 10 characters.
     */
    private function cleanPhone(?string $phone): string
    {
        if (!$phone) return '';
        return substr(preg_replace('/\D/', '', $phone), -10);
    }
}