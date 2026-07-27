<?php

namespace App\Filament\Resources\LeadResource\Widgets;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Reactive;

trait HasLeadFilters
{
    #[Reactive]
    public ?array $filters = [];

    protected function applyFilters(Builder $query): Builder
    {
        if (!empty($this->filters['brand'])) {
            $query->where('raw_request->vehicle->brand_name', 'ilike', "%{$this->filters['brand']}%");
        }
        
        $rango = $this->filters['dateRange'] ?? 'this_month';
        
        if ($rango === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($rango === '7_days') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($rango === '30_days') {
            $query->where('created_at', '>=', now()->subDays(30));
        } elseif ($rango === 'this_month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($rango === 'this_year') {
            $query->whereYear('created_at', now()->year);
        } elseif ($rango === 'custom') {
            if (!empty($this->filters['startDate'])) {
                $query->whereDate('created_at', '>=', $this->filters['startDate']);
            }
            if (!empty($this->filters['endDate'])) {
                $query->whereDate('created_at', '<=', $this->filters['endDate']);
            }
        }

        return $query;
    }
}
