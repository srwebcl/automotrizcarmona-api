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
        Schema::table('legal_documents', function (Blueprint $table) {
            $table->nullableMorphs('legalable');
        });

        // Migrate existing data securely
        \Illuminate\Support\Facades\DB::statement("UPDATE legal_documents SET legalable_type = 'App\\\\Models\\\\Brand', legalable_id = brand_id WHERE brand_id IS NOT NULL");

        Schema::table('legal_documents', function (Blueprint $table) {
            // Safe drop foreign key if exists
            if (\Illuminate\Support\Facades\DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['brand_id']);
            }
            $table->dropColumn('brand_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_documents', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');
        });

        \Illuminate\Support\Facades\DB::statement("UPDATE legal_documents SET brand_id = legalable_id WHERE legalable_type = 'App\\\\Models\\\\Brand'");

        Schema::table('legal_documents', function (Blueprint $table) {
            $table->dropMorphs('legalable');
        });
    }
};
