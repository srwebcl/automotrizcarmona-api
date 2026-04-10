<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBanner extends EditRecord
{
    protected static string $resource = BannerResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['image_mobile']) && !empty($data['image_desktop'])) {
            $data['image_mobile'] = $data['image_desktop'];
        }
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
