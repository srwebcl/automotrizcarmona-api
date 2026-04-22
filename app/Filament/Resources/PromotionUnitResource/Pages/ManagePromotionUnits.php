<?php

namespace App\Filament\Resources\PromotionUnitResource\Pages;

use App\Filament\Resources\PromotionUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePromotionUnits extends ManageRecords
{
    protected static string $resource = PromotionUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
