<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courier;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CourierController extends Controller
{
    /**
     * Fetch couriers from FShip API (for sync feature only)
     */
    public function getAllCouriersFromApi()
    {
        try {
            $response = Http::withHeaders([
                'signature' => config('fship.signature'),
                'Content-Type' => 'application/json'
            ])
            ->timeout(30)
            ->withoutVerifying()
            ->get(config('fship.base_url') . '/getallcourier');

            if ($response->ok()) {
                $data = $response->json();
                return is_array($data) ? $data : ($data['data'] ?? $data['couriers'] ?? []);
            }
            return [];
        } catch (\Exception $e) {
            Log::error('API Courier Fetch Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * ✅ FIXED: Display LOCAL database couriers with pagination
     * Also passes API couriers for dropdown in modal
     */
    public function index()
    {
        try {
            // Fetch LOCAL couriers from database
            $couriers = Courier::latest()->paginate(10);
            
            // Fetch API couriers for modal dropdown (optional)
            $apiCouriers = $this->getAllCouriersFromApi();
            
            return view('admin.couriers.index', compact('couriers', 'apiCouriers'));
            
        } catch (\Exception $e) {
            Log::error('Courier Index Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading couriers: ' . $e->getMessage());
        }
    }

    /**
     * Store new courier in LOCAL database
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'logo_url' => 'nullable|url',
            'rating_pickup' => 'nullable|numeric|min:0|max:5',
            'rating_delivery' => 'nullable|numeric|min:0|max:5',
            'rating_ndr' => 'nullable|numeric|min:0|max:5',
            'rating_weight' => 'nullable|numeric|min:0|max:5',
            'rating_tat' => 'nullable|numeric|min:0|max:5',
            'expected_pickup' => 'nullable|string|max:255',
            'estimated_delivery' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'fship_courier_id' => 'nullable|integer|unique:couriers,fship_courier_id',
        ]);

        try {
            // Handle logo file upload
            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('couriers', 'public');
            }
            
            // Handle logo URL from API or manual input
            if (!$request->hasFile('logo') && $request->filled('logo_url')) {
                $data['logo_url'] = $request->logo_url;
            }

            Courier::create($data);

            return back()->with('success', 'Courier created successfully!');
            
        } catch (\Exception $e) {
            Log::error('Courier Store Error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Fetch courier data for edit modal (AJAX)
     */
    public function edit(Courier $courier)
    {
        return response()->json([
            'success' => true,
            'data' => $courier
        ]);
    }

    /**
     * Update existing courier in LOCAL database
     */
    public function update(Request $request, Courier $courier)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'logo_url' => 'nullable|url',
            'rating_pickup' => 'nullable|numeric|min:0|max:5',
            'rating_delivery' => 'nullable|numeric|min:0|max:5',
            'rating_ndr' => 'nullable|numeric|min:0|max:5',
            'rating_weight' => 'nullable|numeric|min:0|max:5',
            'rating_tat' => 'nullable|numeric|min:0|max:5',
            'expected_pickup' => 'nullable|string|max:255',
            'estimated_delivery' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        try {
            // Handle logo file upload
            if ($request->hasFile('logo')) {
                if ($courier->logo && Storage::disk('public')->exists($courier->logo)) {
                    Storage::disk('public')->delete($courier->logo);
                }
                $data['logo'] = $request->file('logo')->store('couriers', 'public');
            }
            
            // Handle logo URL update
            if ($request->filled('logo_url')) {
                $data['logo_url'] = $request->logo_url;
            }

            $courier->update($data);

            return back()->with('success', 'Courier updated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Courier Update Error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete courier from LOCAL database
     */
    public function destroy(Courier $courier)
    {
        try {
            if ($courier->logo && Storage::disk('public')->exists($courier->logo)) {
                Storage::disk('public')->delete($courier->logo);
            }

            $courier->delete();

            return back()->with('success', 'Courier deleted successfully!');
            
        } catch (\Exception $e) {
            Log::error('Courier Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * ✅ Sync API couriers to local database
     * Route: GET /admin/couriers/sync (named 'sync' in your routes)
     */
    public function syncFromApi()
    {
        try {
            $apiCouriers = $this->getAllCouriersFromApi();
            $synced = 0;
            
            foreach ($apiCouriers as $apiCourier) {
                $courierName = $apiCourier['courierName'] ?? $apiCourier['name'] ?? null;
                if (!$courierName) continue;
                
                // Skip if courier already exists
                if (Courier::where('name', $courierName)->exists()) {
                    continue;
                }
                
                Courier::create([
                    'name' => $courierName,
                    'logo_url' => $apiCourier['logoUrl'] ?? $apiCourier['logo'] ?? null,
                    'is_active' => true,
                ]);
                $synced++;
            }
            
            return back()->with('success', "Synced {$synced} new couriers from API!");
            
        } catch (\Exception $e) {
            Log::error('Courier Sync Error: ' . $e->getMessage());
            return back()->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }
}