<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TruckBrand;
use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function getBrands()
    {
        return response()->json(
            TruckBrand::where('is_active', true)->get()
        );
    }

    public function getTrucksByBrand($slug)
    {
        $brand = TruckBrand::where('slug', $slug)->firstOrFail();
        
        return response()->json([
            'brand' => $brand,
            'trucks' => Truck::where('truck_brand_id', $brand->id)
                ->where('is_active', true)
                ->get()
        ]);
    }
}
