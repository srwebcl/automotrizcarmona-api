<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('discover_servicio_image')->nullable();
            $table->string('discover_repuestos_image')->nullable();
            $table->string('discover_usados_image')->nullable();
            $table->string('discover_sucursales_image')->nullable();
        });
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
