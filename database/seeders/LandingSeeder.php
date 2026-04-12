<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('landings')->updateOrInsert(
            ['slug' => 'promociones'],
            [
                'title' => "Liquidación \nde Stock",
                'subtitle' => 'Unidades físicas con bonos especiales directos por número de chasis (VIN). Válido hasta agotar existencias.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('landings')->updateOrInsert(
            ['slug' => 'electromovilidad'],
            [
                'title' => "Movilidad \nSostenible",
                'subtitle' => 'Descubre nuestra gama de vehículos híbridos y eléctricos. El futuro de la conducción hoy en Automotriz Carmona.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
