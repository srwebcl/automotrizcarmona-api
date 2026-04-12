<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('truck_brands', function (Blueprint $table) {
            $table->boolean('show_in_services')->default(true)->after('is_active');
            $table->boolean('show_in_parts')->default(true)->after('show_in_services');
            $table->boolean('show_in_dyp')->default(true)->after('show_in_parts');
        });
    }

    public function down(): void
    {
        Schema::table('truck_brands', function (Blueprint $table) {
            $table->dropColumn(['show_in_services', 'show_in_parts', 'show_in_dyp']);
        });
    }
};
