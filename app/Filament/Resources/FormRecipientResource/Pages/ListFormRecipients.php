<?php

namespace App\Filament\Resources\FormRecipientResource\Pages;

use App\Filament\Resources\FormRecipientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormRecipients extends ListRecords
{
    protected static string $resource = FormRecipientResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
