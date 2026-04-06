<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeepCleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deep-clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform a deep clean of all caches and compiled views.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Inciando limpieza profunda...');

        $this->call('optimize:clear');
        $this->call('view:clear');
        $this->call('route:clear');
        $this->call('config:clear');
        
        // Filament might be installed, try to optimize
        if (class_exists(\Filament\FilamentServiceProvider::class)) {
            $this->call('filament:optimize-clear');
        }

        // Livewire might be installed
        if (class_exists(\Livewire\LivewireServiceProvider::class)) {
            $this->call('livewire:discover');
        }

        $this->info('✨ ¡Limpieza profunda completada!');
    }
}
