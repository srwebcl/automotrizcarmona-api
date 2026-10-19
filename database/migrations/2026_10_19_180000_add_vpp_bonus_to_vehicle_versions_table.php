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
        Schema::table('vehicle_versions', function (Blueprint $table) {
            $table->unsignedBigInteger('vpp_bonus')->nullable()->default(0)->after('finance_bonus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_versions', function (Blueprint $table) {
            $table->dropColumn('vpp_bonus');
        });
    }
};
