<?php

namespace App\Filament\Exports;

use App\Models\VehicleVersion;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class VehicleVersionExporter extends Exporter
{
    protected static ?string $model = VehicleVersion::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('vehicleModel.brand.name')->label('Marca'),
            ExportColumn::make('vehicleModel.name')->label('Modelo'),
            ExportColumn::make('name')->label('Versión'),
            ExportColumn::make('list_price')->label('Precio Lista'),
            ExportColumn::make('brand_bonus')->label('Bono Marca'),
            ExportColumn::make('finance_bonus')->label('Bono Financiamiento'),
            ExportColumn::make('finance_price')->label('Precio con Financiamiento'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Se ha exportado tu lista de precios correctamente y '.number_format($export->successful_rows).' ' . str('fila')->plural($export->successful_rows) . ' exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron en la exportación.';
        }

        return $body;
    }
}
