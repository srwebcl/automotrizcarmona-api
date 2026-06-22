<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionUnitResource\Pages;
use App\Filament\Resources\PromotionUnitResource\RelationManagers;
use App\Models\PromotionUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromotionUnitResource extends Resource
{
    protected static ?string $model = PromotionUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Landing: Liquidación';
    protected static ?string $pluralLabel = 'Landing: Liquidación';
    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('vehicle_model_id')
                    ->relationship('vehicleModel', 'name')
                    ->required(),
                Forms\Components\TextInput::make('vin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('version_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('promo_bonus')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('promo_price')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('disponible'),
                Forms\Components\TextInput::make('list_price')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('vehicleModel.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('version_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('promo_bonus')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('promo_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('list_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ManagePromotionUnits::route('/'),
        ];
    }
}
