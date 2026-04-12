<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::dropIfExists('promotion_units');
        Schema::create('promotion_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_model_id')->constrained()->onDelete('cascade');
            $table->string('vin')->unique();
            $table->string('version_name')->nullable();
            $table->unsignedBigInteger('promo_bonus')->default(0);
            $table->unsignedBigInteger('promo_price')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_units');
    }
};
