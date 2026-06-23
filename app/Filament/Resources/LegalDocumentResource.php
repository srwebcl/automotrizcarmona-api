<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LegalDocumentResource\Pages;
use App\Models\LegalDocument;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LegalDocumentResource extends Resource
{
    protected static ?string $model = LegalDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationGroup = 'Configuraciones';
    
    protected static ?string $modelLabel = 'Legales y Condiciones';
    
    protected static ?string $pluralModelLabel = 'Legales y Condiciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asignación Universal')
                    ->description('Selecciona si este documento aplica a una Marca o a una Landing Page.')
                    ->schema([
                        Forms\Components\MorphToSelect::make('legalable')
                            ->label('Asignar a')
                            ->types([
                                Forms\Components\MorphToSelect\Type::make(Brand::class)
                                    ->titleAttribute('name')
                                    ->label('Marca de Autos/Motos'),
                                Forms\Components\MorphToSelect\Type::make(\App\Models\Landing::class)
                                    ->titleAttribute('title')
                                    ->label('Landing Page'),
                            ])
                            ->searchable()
                            ->nullable(),
                    ])->columns(1),

                Forms\Components\Section::make('Contenido Legal')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título del Documento')
                            ->placeholder('Ej: Términos y Condiciones Toyota')
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label('Texto Legal Completo (Popup)')
                            ->helperText('Contenido completo que se verá al abrir el popup de condiciones.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('legalable_id')
                    ->label('Asignado a')
                    ->getStateUsing(function ($record) {
                        if (!$record->legalable) return 'Sin asignar';
                        if ($record->legalable instanceof \App\Models\Brand) {
                            return 'Marca: ' . $record->legalable->name;
                        }
                        if ($record->legalable instanceof \App\Models\Landing) {
                            return 'Landing: ' . $record->legalable->title;
                        }
                        return 'Desconocido';
                    })
                    ->badge(),
                TextColumn::make('updated_at')
                    ->label('Última actualización')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
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
            'index' => Pages\ListLegalDocuments::route('/'),
            'create' => Pages\CreateLegalDocument::route('/create'),
            'edit' => Pages\EditLegalDocument::route('/{record}/edit'),
        ];
    }
}
