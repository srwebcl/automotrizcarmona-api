<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public $withinTransaction = false;

    public function up(): void
    {
        DB::statement('ALTER TABLE vehicle_models ADD COLUMN IF NOT EXISTS is_promotion BOOLEAN DEFAULT false');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE vehicle_models DROP COLUMN IF EXISTS is_promotion');
    }
};
