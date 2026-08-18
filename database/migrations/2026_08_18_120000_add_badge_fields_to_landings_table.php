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
        Schema::table('landings', function (Blueprint $table) {
            // Tag/badge configurable por landing (ej. "Liquidatón" en vez de "Liquidación").
            // Si badge_logo_url está seteado, tiene prioridad sobre badge_text en el frontend.
            // Si ninguno está seteado, el frontend cae al texto fijo actual ("Liquidación").
            $table->string('badge_text')->nullable()->after('subtitle');
            $table->string('badge_logo_url')->nullable()->after('badge_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landings', function (Blueprint $table) {
            $table->dropColumn(['badge_text', 'badge_logo_url']);
        });
    }
};
