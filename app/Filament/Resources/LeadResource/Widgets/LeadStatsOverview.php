<?php

namespace App\Filament\Resources\LeadResource\Widgets;

use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class LeadStatsOverview extends BaseWidget
{
    use HasLeadFilters;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        // Total leads con filtros actuales
        $currentLeads = $this->applyFilters(Lead::query())->count();
        
        $rango = $this->filters['dateRange'] ?? 'this_month';
        
        $prevQuery = Lead::query();
        if (!empty($this->filters['brand'])) {
            $prevQuery->where('raw_request->vehicle->brand_name', 'ilike', "%{$this->filters['brand']}%");
        }

        if ($rango === 'today') {
            $prevQuery->whereDate('created_at', today()->subDay());
        } elseif ($rango === '7_days') {
            $prevQuery->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)]);
        } elseif ($rango === '30_days') {
            $prevQuery->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)]);
        } elseif ($rango === 'this_month') {
            $prevQuery->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year);
        } elseif ($rango === 'this_year') {
            $prevQuery->whereYear('created_at', now()->subYear()->year);
        } elseif ($rango === 'custom') {
            if (!empty($this->filters['startDate']) && !empty($this->filters['endDate'])) {
                $start = Carbon::parse($this->filters['startDate']);
                $end = Carbon::parse($this->filters['endDate']);
                $diff = $start->diffInDays($end);
                $prevQuery->whereBetween('created_at', [$start->copy()->subDays($diff), $end->copy()->subDays($diff)]);
            } else {
                $prevQuery->whereRaw('1 = 0');
            }
        }

        $prevLeads = $prevQuery->count();
        
        $percentageChange = $prevLeads > 0 
            ? (($currentLeads - $prevLeads) / $prevLeads) * 100 
            : ($currentLeads > 0 ? 100 : 0);
            
        $trendIcon = $percentageChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $trendColor = $percentageChange >= 0 ? 'success' : 'danger';

        // Best Source
        $topSource = $this->applyFilters(Lead::query())
            ->selectRaw('source, count(*) as total')
            ->groupBy('source')
            ->orderByDesc('total')
            ->first();

        // Best Brand
        $leadsThisPeriod = $this->applyFilters(Lead::query())->get();
        $brandsCount = [];
        
        foreach ($leadsThisPeriod as $lead) {
            $brand = $lead->raw_request['vehicle']['brand_name'] ?? 'Desconocida';
            $brand = ucfirst(strtolower($brand));
            if (!isset($brandsCount[$brand])) {
                $brandsCount[$brand] = 0;
            }
            $brandsCount[$brand]++;
        }
        
        arsort($brandsCount);
        $topBrandName = !empty($brandsCount) ? array_key_first($brandsCount) : 'N/A';
        $topBrandCount = !empty($brandsCount) ? current($brandsCount) : 0;

        return [
            Stat::make('Leads Totales', $currentLeads)
                ->description(abs(round($percentageChange, 1)) . '% vs periodo anterior')
                ->descriptionIcon($trendIcon)
                ->color($trendColor),
                
            Stat::make('Origen Principal', $topSource ? ucfirst($topSource->source) : 'N/A')
                ->description($topSource ? "{$topSource->total} leads generados" : 'Sin datos')
                ->color('primary'),
                
            Stat::make('Marca Más Cotizada', $topBrandName)
                ->description("{$topBrandCount} leads generados")
                ->color('success'),
        ];
    }
}
