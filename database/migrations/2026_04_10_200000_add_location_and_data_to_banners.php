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
        Schema::table('banners', function (Blueprint $table) {
            if (!Schema::hasColumn('banners', 'location')) {
                $table->string('location')->default('home_hero')->after('title');
            }
            if (!Schema::hasColumn('banners', 'custom_data')) {
                $table->json('custom_data')->nullable()->after('active');
            }
        });
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
