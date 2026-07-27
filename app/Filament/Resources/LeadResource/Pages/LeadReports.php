<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Get;
use Filament\Actions;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;

class LeadReports extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $filters = [
        'dateRange' => 'this_month',
        'startDate' => null,
        'endDate' => null,
        'brand' => null,
    ];

    public function mount(): void
    {
        $this->form->fill($this->filters);
    }

    protected static string $resource = LeadResource::class;

    protected static string $view = 'filament.resources.lead-resource.pages.lead-reports';

    protected static ?string $title = 'Reportes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('dateRange')
                            ->label('Periodo de Tiempo')
                            ->options([
                                'today' => 'Hoy',
                                '7_days' => 'Últimos 7 días',
                                '30_days' => 'Últimos 30 días',
                                'this_month' => 'Este Mes',
                                'this_year' => 'Este Año',
                                'custom' => 'Personalizado',
                            ])
                            ->default('this_month')
                            ->live(),
                        DatePicker::make('startDate')
                            ->label('Desde')
                            ->displayFormat('d/m/Y')
                            ->hidden(fn (Get $get) => $get('dateRange') !== 'custom')
                            ->live(),
                        DatePicker::make('endDate')
                            ->label('Hasta')
                            ->displayFormat('d/m/Y')
                            ->hidden(fn (Get $get) => $get('dateRange') !== 'custom')
                            ->live(),
                        Select::make('brand')
                            ->label('Filtrar por Marca')
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
                            ])
                            ->searchable()
                            ->placeholder('Todas las marcas')
                            ->live(),
                    ])
                    ->columns(4),
            ])->statePath('filters');
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 2;
    }

    public function getReportWidgets(): array
    {
        return [
            \App\Filament\Resources\LeadResource\Widgets\LeadStatsOverview::class,
            \App\Filament\Resources\LeadResource\Widgets\LeadsByBrandAndSourceTable::class,
            \App\Filament\Resources\LeadResource\Widgets\LeadsTrendChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
