<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        DB::statement("
            CREATE TABLE IF NOT EXISTS marketing_scripts (
                id          BIGSERIAL PRIMARY KEY,
                name        VARCHAR(255) NOT NULL,
                type        VARCHAR(50)  NOT NULL DEFAULT 'custom',
                value       TEXT         NOT NULL,
                placement   VARCHAR(50)  NOT NULL DEFAULT 'head',
                is_active   BOOLEAN      NOT NULL DEFAULT TRUE,
                \"order\"     INTEGER      NOT NULL DEFAULT 0,
                created_at  TIMESTAMP,
                updated_at  TIMESTAMP
            )
        ");
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS marketing_scripts');
    }
};
