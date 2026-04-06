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
    
    protected static ?string $navigationGroup = 'Ventas';

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
                    ->label('Email'),
                TextColumn::make('source')
                    ->label('Origen')
                    ->badge(),
                IconColumn::make('crm_synced')
                    ->boolean()
                    ->label('CRM'),
            ])
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
                Tables\Filters\TernaryFilter::make('crm_synced')
                    ->label('Sincronizado'),
            ])
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
            // 'create' => Pages\CreateLead::route('/create'), // Los leads no se crean manualmente
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
