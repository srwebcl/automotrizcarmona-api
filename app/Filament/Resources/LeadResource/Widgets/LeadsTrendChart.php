<?php

namespace App\Filament\Resources\LeadResource\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class LeadsTrendChart extends ChartWidget
{
    use HasLeadFilters;

    protected static ?string $heading = 'Evolución de Leads';

    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '300px';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        // Generar los últimos 30 días
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::now()->subDays($i)->format('d/m');
            $data[$date] = 0;
        }

        $leads = $this->applyFilters(Lead::query())
            ->selectRaw('DATE(created_at) as date, count(*) as total')
            ->groupBy('date')
            ->get();

        foreach ($leads as $lead) {
            if (isset($data[$lead->date])) {
                $data[$lead->date] = $lead->total;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Nuevos Leads',
                    'data' => array_values($data),
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => '#3b82f6',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'elements' => [
                'line' => [
                    'tension' => 0.4, // Curvas suaves
                    'borderWidth' => 3,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                ],
                'y' => [
                    'grid' => [
                        'color' => 'rgba(0, 0, 0, 0.05)',
                        'drawBorder' => false,
                    ],
                    'beginAtZero' => true,
                    'ticks' => ['stepSize' => 1],
                ],
            ],
        ];
    }
}
