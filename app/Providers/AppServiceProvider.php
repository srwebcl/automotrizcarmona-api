<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Filament\Forms\Components\Select::configureUsing(function (\Filament\Forms\Components\Select $component): void {
            $component->native(false);
        });

        \Filament\Forms\Components\DateTimePicker::configureUsing(function (\Filament\Forms\Components\DateTimePicker $component): void {
            $component->native(false);
        });

        \Filament\Forms\Components\DatePicker::configureUsing(function (\Filament\Forms\Components\DatePicker $component): void {
            $component->native(false);
        });

        \Filament\Forms\Components\TimePicker::configureUsing(function (\Filament\Forms\Components\TimePicker $component): void {
            $component->native(false);
        });

        // Registrar consultas a base de datos que tarden más de 1 segundo
        \Illuminate\Support\Facades\DB::listen(function ($query) {
            if ($query->time > 1000) {
                \Illuminate\Support\Facades\Log::warning("Consulta Lenta Detectada (>1s)", [
                    'sql' => $query->sql,
                    'time' => $query->time . 'ms'
                ]);
            }
        });
    }
}
