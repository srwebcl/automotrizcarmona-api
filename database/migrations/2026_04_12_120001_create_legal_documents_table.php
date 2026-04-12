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

        if (!Schema::hasTable('legal_documents')) {
            Schema::create('legal_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');
                // Removing truck_brand_id as requested
                $table->string('title');
                $table->text('excerpt')->nullable();
                $table->longText('content')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};
