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
    }
}
