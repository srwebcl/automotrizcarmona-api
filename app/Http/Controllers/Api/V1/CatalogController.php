<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BannerResource;
use App\Http\Resources\V1\BranchResource;
use App\Http\Resources\V1\BrandResource;
use App\Http\Resources\V1\NewsResource;
use App\Http\Resources\V1\VehicleModelResource;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\News;
use App\Models\VehicleModel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CatalogController extends Controller
{
    /**
     * Get all active banners for Marketing.
     */
    public function banners(): AnonymousResourceCollection
    {
        return BannerResource::collection(Banner::where('active', true)->orderBy('order')->get());
    }

    /**
     * Get all branches.
     */
    public function branches(): AnonymousResourceCollection
    {
        return BranchResource::collection(Branch::all());
    }

    /**
     * Get all news.
     */
    public function news(): AnonymousResourceCollection
    {
        return NewsResource::collection(News::orderByDesc('published_at')->get());
    }

    /**
     * Get all brands.
     */
    public function brands(): AnonymousResourceCollection
    {
        return BrandResource::collection(Brand::where('is_active', true)->orderBy('name')->get());
    }

    /**
     * Get models for a specific brand (List view).
     */
    public function modelsByBrand(string $brand_slug): AnonymousResourceCollection
    {
        $brand = Brand::where('slug', $brand_slug)->firstOrFail();
        
        $models = VehicleModel::where('brand_id', $brand->id)
            ->where('is_active', true)
            ->with('vehicleVersions')
            ->orderBy('name')
            ->get();

        return VehicleModelResource::collection($models);
    }

    /**
     * Get detailed brand information.
     */
    public function brandBySlug(string $slug): BrandResource
    {
        $brand = Brand::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        return new BrandResource($brand);
    }

    /**
     * Get detailed model information.
     */
    public function modelDetails(string $brand_slug, string $model_slug): VehicleModelResource
    {
        $brand = Brand::where('slug', $brand_slug)->firstOrFail();

        $model = VehicleModel::where('brand_id', $brand->id)
            ->where('slug', $model_slug)
            ->with(['brand', 'vehicleVersions', 'features'])
            ->firstOrFail();

        return new VehicleModelResource($model);
    }

    /**
     * Get featured models for Home.
     */
    public function featured(): AnonymousResourceCollection
    {
        $models = VehicleModel::where('is_active', true)
            ->where('is_featured', true)
            ->with(['brand', 'vehicleVersions'])
            ->limit(10)
            ->get();

        return VehicleModelResource::collection($models);
    }
}
