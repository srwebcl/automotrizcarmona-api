<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingResource\Pages;
use App\Models\Landing;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LandingResource extends Resource
{
    protected static ?string $model = Landing::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    
    protected static ?string $navigationGroup = 'Configuraciones';

    protected static ?string $label = 'Landing Page';
    protected static ?string $pluralLabel = 'Landing Pages';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Configuración General')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug / Ruta')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('promociones, electromovilidad...')
                            ->helperText('Debe coincidir con la ruta en el frontend.'),
                        TextInput::make('title')
                            ->label('Título Hero')
                            ->required()
                            ->placeholder('Ej: Liquidación de Stock'),
                        TextInput::make('subtitle')
                            ->label('Subtítulo Hero')
                            ->placeholder('Ej: Unidades limitadas con bonos exclusivos'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Publicado')
                            ->default(true),
                    ])->columns(2),

                Section::make('Multimedia (Banners)')
                    ->schema([
                        FileUpload::make('desktop_banner_url')
                            ->label('Banner Desktop')
                            ->image()
                            ->disk('r2')
                            ->directory('landings')
                            ->fetchFileInformation(false),
                        FileUpload::make('mobile_banner_url')
                            ->label('Banner Mobile')
                            ->image()
                            ->disk('r2')
                            ->directory('landings')
                            ->fetchFileInformation(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')->label('Ruta')->badge()->color('info'),
                TextColumn::make('title')->label('Título')->searchable(),
                ImageColumn::make('desktop_banner_url')->label('Banner')->disk('r2'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Activo'),
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
            'index' => Pages\ListLandings::route('/'),
            'create' => Pages\CreateLanding::route('/create'),
            'edit' => Pages\EditLanding::route('/{record}/edit'),
        ];
    }
}
