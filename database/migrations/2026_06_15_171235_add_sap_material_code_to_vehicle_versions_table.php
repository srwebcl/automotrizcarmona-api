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
            $table->string('sap_material_code')->nullable()->after('name')->comment('Toyota Mulesoft Material Code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_versions', function (Blueprint $table) {
            $table->dropColumn('sap_material_code');
        });
    }
};
