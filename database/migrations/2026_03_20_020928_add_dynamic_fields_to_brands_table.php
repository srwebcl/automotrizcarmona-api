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
        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('hero_banners');
            $table->string('category')->default('autos')->after('is_active'); // autos, camiones
            $table->boolean('show_in_services')->default(true)->after('category');
            $table->boolean('show_in_parts')->default(true)->after('show_in_services');
            $table->boolean('show_in_dyp')->default(true)->after('show_in_parts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'category', 'show_in_services', 'show_in_parts', 'show_in_dyp']);
        });
    }
};
