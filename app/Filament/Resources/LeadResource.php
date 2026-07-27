<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    
    protected static ?string $navigationGroup = 'Configuraciones';

    protected static ?string $label = 'Lead / Contacto';
    protected static ?string $pluralLabel = 'Leads y Contactos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Lead')
                    ->schema([
                        TextInput::make('source')->label('Origen')->disabled(),
                        TextInput::make('rut')->label('RUT')->disabled(),
                        TextInput::make('name')->label('Nombre Completo')->disabled(),
                        TextInput::make('email')->label('Email')->disabled(),
                        TextInput::make('phone')->label('Teléfono')->disabled(),
                        TextInput::make('vehicle_id')
                            ->label('ID Vehículo Interés')
                            ->disabled(),
                        Textarea::make('message')->label('Mensaje')->disabled(),
                        Toggle::make('crm_synced')
                            ->label('Sincronizado con CRM')
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Fecha')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nombre Completo')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('raw_request.vehicle.brand_name')
                    ->label('Marca')
                    ->searchable(query: function (\Illuminate\Database\Eloquent\Builder $query, string $search) {
                        return $query->where('raw_request->vehicle->brand_name', 'ilike', "%{$search}%");
                    })
                    ->sortable(query: function (\Illuminate\Database\Eloquent\Builder $query, string $direction) {
                        return $query->orderBy('raw_request->vehicle->brand_name', $direction);
                    }),
                TextColumn::make('vehicle_id')
                    ->label('Modelo')
                    ->searchable(),
                TextColumn::make('source')
                    ->label('Origen')
                    ->badge(),
                IconColumn::make('crm_synced')
                    ->boolean()
                    ->label('CRM'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('source')
                    ->label('Origen')
                    ->options([
                        'ventas' => 'Ventas',
                        'dyp' => 'DyP',
                        'servicio_tecnico' => 'Servicio Técnico',
                        'repuestos' => 'Repuestos',
                        'reclamos' => 'Reclamos',
                    ]),
                Tables\Filters\Filter::make('date_filter')
                    ->form([
                        Forms\Components\Select::make('rango')
                            ->label('Fecha')
                            ->options([
                                'today' => 'Hoy',
                                '7_days' => 'Últimos 7 días',
                                '30_days' => 'Últimos 30 días',
                                'this_month' => 'Este mes',
                            ])
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        return $query->when(
                            $data['rango'] ?? null,
                            function (\Illuminate\Database\Eloquent\Builder $query, $rango) {
                                if ($rango === 'today') return $query->whereDate('created_at', today());
                                if ($rango === '7_days') return $query->where('created_at', '>=', now()->subDays(7));
                                if ($rango === '30_days') return $query->where('created_at', '>=', now()->subDays(30));
                                if ($rango === 'this_month') return $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                                return $query;
                            }
                        );
                    }),
                Tables\Filters\Filter::make('brand')
                    ->form([
                        Forms\Components\Select::make('brand')
                            ->label('Marca')
                            ->options([
                                'Toyota' => 'Toyota',
                                'Volkswagen' => 'Volkswagen',
                                'MG' => 'MG',
                                'Geely' => 'Geely',
                                'Audi' => 'Audi',
                                'Skoda' => 'Skoda',
                                'Seat' => 'Seat',
                                'Subaru' => 'Subaru',
                                'Cupra' => 'Cupra',
                                'Soueast' => 'Soueast',
                                'Dongfeng' => 'Dongfeng',
                                'JAC' => 'JAC',
                                'GWM' => 'GWM',
                                'Haval' => 'Haval',
                                'Changan' => 'Changan',
                                'Suzuki' => 'Suzuki',
                                'Renault' => 'Renault',
                                'Mazda' => 'Mazda',
                            ])
                            ->searchable(),
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        return $query->when(
                            $data['brand'] ?? null,
                            fn (\Illuminate\Database\Eloquent\Builder $query, $brand): \Illuminate\Database\Eloquent\Builder => $query->where('raw_request->vehicle->brand_name', 'ilike', "%{$brand}%")
                        );
                    }),
                Tables\Filters\Filter::make('model')
                    ->form([
                        Forms\Components\TextInput::make('model')
                            ->label('Modelo'),
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        return $query->when(
                            $data['model'] ?? null,
                            fn (\Illuminate\Database\Eloquent\Builder $query, $model): \Illuminate\Database\Eloquent\Builder => $query->where('vehicle_id', 'ilike', "%{$model}%")
                        );
                    }),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'reportes' => Pages\LeadReports::route('/reportes'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Lead de Venta';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Leads y Contactos';
    }
}
