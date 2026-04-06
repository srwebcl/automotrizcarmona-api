<?php

namespace App\Filament\Resources\VehicleVersionResource\Pages;

use App\Filament\Resources\VehicleVersionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicleVersion extends EditRecord
{
    protected static string $resource = VehicleVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
