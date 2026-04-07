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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('truck_brands', function (Blueprint $table) {
            $table->string('hero_banner_desktop')->nullable()->after('logo_url');
            $table->string('hero_banner_mobile')->nullable()->after('hero_banner_desktop');
        });
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

 
