<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['image_mobile']) && !empty($data['image_desktop'])) {
            $data['image_mobile'] = $data['image_desktop'];
        }

        if (!empty($data['is_external_link'])) {
            $data['link'] = $data['external_link'] ?? null;
        } else {
            $data['link'] = $data['internal_link'] ?? null;
        }

        unset($data['is_external_link'], $data['internal_link'], $data['external_link']);

        return $data;
    }
}
