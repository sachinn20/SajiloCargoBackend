<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PricingSetting;


class PriceSettingController extends Controller
{
    public function getPricing()
    {
        $pricing = PricingSetting::first();

        if (!$pricing) {
            return response()->json(['error' => 'Pricing data not found.'], 404);
        }

        return response()->json([
            'price_per_km' => $pricing->price_per_km,
            'price_per_kg' => $pricing->price_per_kg
        ]);
    }
}
