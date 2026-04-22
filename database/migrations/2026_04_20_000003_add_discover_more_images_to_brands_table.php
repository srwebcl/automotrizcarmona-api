<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE brands ADD COLUMN IF NOT EXISTS discover_servicio_image VARCHAR(255) NULL');
        DB::statement('ALTER TABLE brands ADD COLUMN IF NOT EXISTS discover_repuestos_image VARCHAR(255) NULL');
        DB::statement('ALTER TABLE brands ADD COLUMN IF NOT EXISTS discover_usados_image VARCHAR(255) NULL');
        DB::statement('ALTER TABLE brands ADD COLUMN IF NOT EXISTS discover_sucursales_image VARCHAR(255) NULL');
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn([
                'discover_servicio_image',
                'discover_repuestos_image',
                'discover_usados_image',
                'discover_sucursales_image'
            ]);
        });
    }
};
