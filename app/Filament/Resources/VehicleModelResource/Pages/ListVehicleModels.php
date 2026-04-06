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
        $tabs = ['all' => \Filament\Resources\Components\Tab::make('Todas')];

        $brands = \Illuminate\Support\Facades\Cache::remember('brands_for_models_tabs', 300, fn() => \App\Models\Brand::where('is_active', true)->orderBy('name')->get());

        foreach ($brands as $brand) {
            $tabs[$brand->slug] = \Filament\Resources\Components\Tab::make($brand->name)
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('brand_id', $brand->id));
        }

        return $tabs;
    }
}
