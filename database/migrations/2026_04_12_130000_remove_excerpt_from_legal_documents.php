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
        
        try {
            DB::statement('ALTER TABLE legal_documents DROP COLUMN IF EXISTS excerpt;');
        } catch (\Exception $e) {
            try { DB::unprepared('ROLLBACK'); } catch (\Exception $e2) {}
        }
    }

    public function down(): void
    {
        try { DB::unprepared('ROLLBACK'); } catch (\Exception $e) {}
        
        try {
            DB::statement('ALTER TABLE legal_documents ADD COLUMN IF NOT EXISTS excerpt TEXT NULL;');
        } catch (\Exception $e) {
            try { DB::unprepared('ROLLBACK'); } catch (\Exception $e2) {}
        }
    }
};
