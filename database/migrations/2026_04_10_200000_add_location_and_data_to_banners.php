<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Disable transactions to prevent PostgreSQL deadlock or aborted transaction cascade.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Usamos SQL nativo de Postgres para evitar problemas de transacciones abortadas al leer el esquema en medio de la migración
        DB::statement("ALTER TABLE banners ADD COLUMN IF NOT EXISTS location VARCHAR(255) DEFAULT 'home_hero'");
        DB::statement("ALTER TABLE banners ADD COLUMN IF NOT EXISTS custom_data JSONB NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['location', 'custom_data']);
        });
    }
};
