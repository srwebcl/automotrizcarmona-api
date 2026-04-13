<?php

namespace App\Filament\Resources\VehicleVersionResource\Pages;

use App\Filament\Resources\VehicleVersionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicleVersions extends ListRecords
{
    protected static string $resource = VehicleVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        $counts = \App\Models\VehicleVersion::join('vehicle_models', 'vehicle_versions.vehicle_model_id', '=', 'vehicle_models.id')
            ->select('vehicle_models.brand_id', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('vehicle_models.brand_id')
            ->pluck('count', 'brand_id');

        $tabs = [
            'all' => \Filament\Resources\Components\Tab::make('Todas')
                ->badge(\App\Models\VehicleVersion::count())
        ];

        $brands = \Illuminate\Support\Facades\Cache::remember('brands_for_versions_tabs_list', 300, function() {
            return \App\Models\Brand::where('is_active', true)->orderBy('name')->get();
        });

        foreach ($brands as $brand) {
            $tabs[$brand->slug] = \Filament\Resources\Components\Tab::make($brand->name)
                ->badge($counts->get($brand->id, 0))
                ->badgeColor('primary')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->whereHas('vehicleModel', fn (\Illuminate\Database\Eloquent\Builder $q) => $q->where('brand_id', $brand->id)));
        }

        return $tabs;
    }
}
