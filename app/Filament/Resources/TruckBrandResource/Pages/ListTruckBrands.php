<?php

namespace App\Filament\Resources\TruckBrandResource\Pages;

use App\Filament\Resources\TruckBrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTruckBrands extends ListRecords
{
    protected static string $resource = TruckBrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
