<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            // Default false: no afecta ningún vehículo existente, solo se activa
            // manualmente en Filament para los modelos que correspondan.
            $table->boolean('is_microhybrid')->default(false)->after('is_electric');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            $table->dropColumn('is_microhybrid');
        });
    }
};
