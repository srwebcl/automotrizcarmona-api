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
        // Update branches table
        Schema::table('branches', function (Blueprint $table) {
            // Rename opening_hours to schedule for consistency with requested field (if it exists)
            if (Schema::hasColumn('branches', 'opening_hours')) {
                $table->renameColumn('opening_hours', 'schedule');
            } else {
                $table->text('schedule')->nullable();
            }

            $table->string('type')->default('Sala de Ventas')->after('name'); // Sala de Ventas, Servicio Técnico, etc.
            $table->string('city')->nullable()->after('address');
            $table->string('manager_name')->nullable()->after('city');
            $table->text('map_link')->nullable()->after('schedule');
            $table->string('image_url')->nullable()->after('map_link');
            
            // Drop old lat/lng columns as they weren't requested this time, or keep them if needed?
            // User requested map_link (text) instead.
            $table->dropColumn(['lat', 'lng']);
        });

        // Create pivot table
        Schema::create('brand_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_branch');

        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn(['type', 'city', 'manager_name', 'map_link', 'image_url']);
            $table->renameColumn('schedule', 'opening_hours');
            $table->float('lat', 10, 6)->nullable();
            $table->float('lng', 10, 6)->nullable();
        });
    }
};
