<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        try { DB::unprepared('ROLLBACK'); } catch (\Exception $e) {}

        if (!Schema::hasColumn('truck_brands', 'show_in_services')) {
            Schema::table('truck_brands', function (Blueprint $table) {
                $table->boolean('show_in_services')->default(true);
            });
        }
        
        if (!Schema::hasColumn('truck_brands', 'show_in_parts')) {
            Schema::table('truck_brands', function (Blueprint $table) {
                $table->boolean('show_in_parts')->default(true);
            });
        }
        
        if (!Schema::hasColumn('truck_brands', 'show_in_dyp')) {
            Schema::table('truck_brands', function (Blueprint $table) {
                $table->boolean('show_in_dyp')->default(true);
            });
        }
    }

    public function down(): void
    {
        Schema::table('truck_brands', function (Blueprint $table) {
            if (Schema::hasColumn('truck_brands', 'show_in_services')) {
                $table->dropColumn('show_in_services');
            }
            if (Schema::hasColumn('truck_brands', 'show_in_parts')) {
                $table->dropColumn('show_in_parts');
            }
            if (Schema::hasColumn('truck_brands', 'show_in_dyp')) {
                $table->dropColumn('show_in_dyp');
            }
        });
    }
};
