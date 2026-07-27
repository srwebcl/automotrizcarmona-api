<?php

namespace App\Filament\Resources\LeadResource\Widgets;

use App\Models\Lead;
use Filament\Widgets\Widget;

class LeadsByBrandAndSourceTable extends Widget
{
    use HasLeadFilters;

    protected static string $view = 'filament.resources.lead-resource.widgets.leads-by-brand-and-source-table';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        // En lugar de hacer selectRaw en BD, descargamos los filtrados y agrupamos en PHP
        // Esto es seguro si no son millones, o podemos hacerlo via DB
        $leads = $this->applyFilters(Lead::query())
            ->select('source', 'raw_request')
            ->get();
        
        $data = [];
        $sources = ['ventas', 'contacto', 'dyp', 'repuestos', 'servicio_tecnico', 'reclamos'];
        
        foreach ($leads as $lead) {
            $brand = data_get($lead->raw_request, 'vehicle.brand_name', 'Sin Marca');
            $brand = strtoupper($brand);
            $source = $lead->source ?? 'sin_origen';
            
            if (!isset($data[$brand])) {
                $data[$brand] = [
                    'brand' => $brand,
                    'total' => 0,
                ];
                foreach ($sources as $s) {
                    $data[$brand][$s] = 0;
                }
            }
            
            if (in_array($source, $sources)) {
                $data[$brand][$source]++;
            }
            $data[$brand]['total']++;
        }

        // Sort by total desc
        usort($data, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        return [
            'sources' => $sources,
            'data' => $data,
        ];
    }
}
