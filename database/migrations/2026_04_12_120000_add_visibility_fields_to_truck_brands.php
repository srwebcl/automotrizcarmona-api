<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('truck_brands', function (Blueprint $table) {
            if (!Schema::hasColumn('truck_brands', 'show_in_services')) {
                $table->boolean('show_in_services')->default(true)->after('is_active');
            }
            if (!Schema::hasColumn('truck_brands', 'show_in_parts')) {
                $table->boolean('show_in_parts')->default(true)->after('is_active');
            }
            if (!Schema::hasColumn('truck_brands', 'show_in_dyp')) {
                $table->boolean('show_in_dyp')->default(true)->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('truck_brands', function (Blueprint $table) {
            $table->dropColumn(['show_in_services', 'show_in_parts', 'show_in_dyp']);
        });
    }
};
