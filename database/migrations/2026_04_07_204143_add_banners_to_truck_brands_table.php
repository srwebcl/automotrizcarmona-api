<?php
/*
 * Este archivo fue generado por Antigravity para a\u00f1adir banners hero a las marcas de camiones.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Disable transactions for this migration to avoid Postgres aborted transaction deadlocks.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE "truck_brands" ADD COLUMN IF NOT EXISTS "hero_banner_desktop" VARCHAR(255) NULL');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE "truck_brands" ADD COLUMN IF NOT EXISTS "hero_banner_mobile" VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('truck_brands', function (Blueprint $table) {
            $table->dropColumn(['hero_banner_desktop', 'hero_banner_mobile']);
        });
    }
};

 
