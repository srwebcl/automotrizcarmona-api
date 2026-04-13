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

        if (!empty($data['is_external_link'])) {
            $data['link'] = $data['external_link'] ?? null;
        } else {
            $data['link'] = $data['internal_link'] ?? null;
        }

        unset($data['is_external_link'], $data['internal_link'], $data['external_link']);

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $link = $data['link'] ?? '';
        
        if ($link && str_starts_with($link, 'http')) {
            $data['is_external_link'] = true;
            $data['external_link'] = $link;
            $data['internal_link'] = null;
        } else {
            $data['is_external_link'] = false;
            $data['internal_link'] = $link;
            $data['external_link'] = null;
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
