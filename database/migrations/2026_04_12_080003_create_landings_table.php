<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::dropIfExists('landings');
        Schema::create('landings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // e.g., 'promociones', 'electromovilidad'
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('desktop_banner_url')->nullable();
            $table->string('mobile_banner_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landings');
    }
};
