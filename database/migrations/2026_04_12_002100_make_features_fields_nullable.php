<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        DB::statement('ALTER TABLE features ALTER COLUMN title DROP NOT NULL');
        // description was already nullable in the original schema, but we ensure it just in case
        DB::statement('ALTER TABLE features ALTER COLUMN description DROP NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE features ALTER COLUMN title SET NOT NULL');
    }
};
