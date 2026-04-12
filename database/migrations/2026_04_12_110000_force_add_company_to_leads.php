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
        if (!Schema::hasColumn('leads', 'company')) {
            try {
                Schema::table('leads', function (Blueprint $table) {
                    $table->string('company')->nullable()->after('phone');
                });
            } catch (\Exception $e) {
                // If it fails due to locking, use raw SQL
                try {
                    DB::statement('ALTER TABLE leads ADD COLUMN company VARCHAR(255) NULL;');
                } catch (\Exception $e2) {
                    // Ignore, maybe someone locked it
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('leads', 'company')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->dropColumn('company');
            });
        }
    }
};
