<?php

namespace App\Filament\Resources\VehicleModelResource\Pages;

use App\Filament\Resources\VehicleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicleModels extends ListRecords
{
    protected static string $resource = VehicleModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => \Filament\Resources\Components\Tab::make('Todas')
                ->badge(\App\Models\VehicleModel::count())
        ];

        $brands = \Illuminate\Support\Facades\Cache::remember('brands_for_models_tabs_with_counts', 300, function() {
            return \App\Models\Brand::where('is_active', true)
                ->withCount('vehicleModels')
                ->orderBy('name')
                ->get();
        });

        foreach ($brands as $brand) {
            $tabs[$brand->slug] = \Filament\Resources\Components\Tab::make($brand->name)
                ->badge($brand->vehicle_models_count)
                ->badgeColor('primary')
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('brand_id', $brand->id));
        }

        return $tabs;
    }
}
