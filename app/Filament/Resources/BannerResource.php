<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';
    
    protected static ?string $navigationGroup = 'Marketing';

    protected static ?string $label = 'Banner';
    protected static ?string $pluralLabel = 'Banners';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('Título')
                    ->required(),
                TextInput::make('subtitle')->label('Subtítulo'),
                FileUpload::make('image_desktop')->label('Imagen Desktop')
                    ->image()
                    ->directory('banners')
                    ->required(),
                FileUpload::make('image_mobile')->label('Imagen Móvil')
                    ->image()
                    ->directory('banners')
                    ->required(),
                TextInput::make('link')->label('Enlace (URL)'),
                TextInput::make('order')->label('Orden')
                    ->numeric()
                    ->default(0),
                Toggle::make('active')->label('Activo')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_desktop')
                    ->label('Imagen')
                    ->disk('public')
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->square(),
                TextColumn::make('title')->label('Título')->searchable(),
                TextColumn::make('order')->label('Orden')->sortable(),
                ToggleColumn::make('active')->label('Estado'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
