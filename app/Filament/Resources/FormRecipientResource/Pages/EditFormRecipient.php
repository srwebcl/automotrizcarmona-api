<?php

namespace App\Filament\Resources\FormRecipientResource\Pages;

use App\Filament\Resources\FormRecipientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormRecipient extends EditRecord
{
    protected static string $resource = FormRecipientResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
