<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    
    protected static ?string $navigationGroup = 'Configuraciones';

    protected static ?string $label = 'Noticia';
    protected static ?string $pluralLabel = 'Noticias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    // Columna Izquierda (Contenido Principal)
                    Forms\Components\Group::make()->columnSpan(2)->schema([
                        Forms\Components\Section::make('Información Principal')->schema([
                            TextInput::make('title')->label('Título de la Noticia')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                                
                            TextInput::make('slug')->label('Slug (URL Amigable)')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->helperText('Este texto se usa para formar el link de la noticia.'),
                        ])->columns(2),

                        Forms\Components\Section::make('Cuerpo de la Noticia')->schema([
                            RichEditor::make('content')->label('Contenido')
                                ->disableLabel()
                                ->required(),
                        ]),
                    ]),

                    // Columna Derecha (Medios y Publicación)
                    Forms\Components\Group::make()->columnSpan(1)->schema([
                        Forms\Components\Section::make('Archivo Multimedia')->schema([
                            FileUpload::make('image')->label('Imagen de Portada o Cabecera')
                                ->image()
                                ->disk('r2')
                                ->directory('news')
                                ->required(),
                        ]),

                        Forms\Components\Section::make('Ajustes de Publicación')->schema([
                            DateTimePicker::make('published_at')->label('Fecha de Publicación visible')
                                ->default(now())
                                ->required(),
                        ]),
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Imagen'),
                TextColumn::make('title')->label('Título')->searchable()->sortable(),
                TextColumn::make('published_at')->label('Publicado el')->dateTime()->sortable(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
