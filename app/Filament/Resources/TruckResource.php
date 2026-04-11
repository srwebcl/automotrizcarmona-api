<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TruckResource\Pages;
use App\Filament\Resources\TruckResource\RelationManagers;
use App\Models\Truck;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = '🚛 Camiones';
    protected static ?string $modelLabel = 'Modelo de Camión';
    protected static ?string $pluralModelLabel = 'Modelos de Camiones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('truck_brand_id')
                    ->label('Marca')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Modelo')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug / URL')
                    ->required()
                    ->unique(Truck::class, 'slug', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image_url')
                    ->label('Miniatura del Camión')
                    ->disk('r2')
                    ->directory('trucks')
                    ->visibility('public')
                    ->image()
                    ->imageEditor()
                    ->fetchFileInformation(false)
                    ->helperText('Sube la miniatura del camión directamente a Cloudflare R2.'),
                Forms\Components\Select::make('category')
                    ->label('Categoría')
                    ->options([
                        'Pesados'  => 'Pesados',
                        'Medianos' => 'Medianos',
                        'Buses'    => 'Buses',
                        'Pick-up'  => 'Pick-up',
                    ])
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre de la nueva categoría')
                            ->required(),
                    ])
                    ->createOptionUsing(fn (array $data) => $data['name'])
                    ->nullable()
                    ->searchable()
                    ->helperText('Selecciona una categoría existente o crea una nueva escribiéndola y presionando "Crear".'),
                Forms\Components\Toggle::make('is_active')
                    ->label('¿Está activo?')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Modelo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Categoría')
                    ->badge()
                    ->color('primary')
                    ->default('Sin categoría'),
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Imagen')
                    ->disk('r2')
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->height(40),
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrucks::route('/'),
            'create' => Pages\CreateTruck::route('/create'),
            'edit' => Pages\EditTruck::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['brand']);
    }
}
