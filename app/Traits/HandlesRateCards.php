<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

trait HandlesRateCards
{
    /**
     * Rate Card validation rules
     */
   public function rateCardRules($id = null)
{
    $rules = [
        'user_id'    => 'required|exists:users,id',
        'courier_id' => 'required|exists:couriers,id', // ✅ FIXED
        'type'       => 'required|in:MINI,B2C,B2B',
        'mode'       => 'required|in:surface,air,express',
        'plan_name'  => 'nullable|string|max:50',
        'weight_info'=> 'nullable|string|max:255',
        'add_weight' => 'nullable|numeric|min:0',
        'is_active'  => 'required|in:0,1',

        'mode_icon'  => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:1024',
    ];

    $zones = ['a', 'b', 'c', 'd', 'e'];
    $fields = ['forward', 'rto', 'add_forward', 'add_rto', 'cod_charge', 'cod_percent'];

    foreach ($zones as $z) {
        foreach ($fields as $f) {
            $rules["zone_{$z}_{$f}"] = 'nullable|numeric|min:0';
        }
    }

    return $rules;
}

    /**
     * Handle file uploads + API logo logic
     */
    public function uploadRateCardFiles($request, $model = null)
{
    $data = $request->all();

    if ($request->hasFile('mode_icon')) {
        $this->deleteOldFile($model, 'mode_icon');
        $data['mode_icon'] = $request->file('mode_icon')->store('rate-cards/icons', 'public');
    }

    return $data;
}

    /**
     * Helper to delete old files
     */
    private function deleteOldFile($model, $field)
    {
        if ($model && $model->$field && Storage::disk('public')->exists($model->$field)) {
            Storage::disk('public')->delete($model->$field);
        }
    }

    /**
     * Group rate cards by user
     */
    public function formatUserWise($rateCards)
    {
        return $rateCards->groupBy('user_id')->map(function ($items) {
            return [
                'user' => $items->first()->user,
                'cards' => $items
            ];
        });
    }
}