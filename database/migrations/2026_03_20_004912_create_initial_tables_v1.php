<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo_url')->nullable();
            $table->string('brand_color_css')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('legal_text')->nullable();
            $table->json('hero_banners')->nullable();
            $table->timestamps();
        });

        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('desktop_banner_url')->nullable();
            $table->string('mobile_banner_url')->nullable();
            $table->string('video_url')->nullable();
            $table->json('gallery')->nullable();
            $table->decimal('base_price', 15, 2)->nullable();
            $table->string('slogan')->nullable();
            $table->boolean('is_new')->default(true);
            $table->boolean('is_hybrid')->default(false);
            $table->boolean('is_electric')->default(false);
            $table->timestamps();
        });

        Schema::create('vehicle_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_model_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('transmission')->nullable();
            $table->string('traction')->nullable();
            $table->string('fuel')->nullable();
            $table->decimal('list_price', 15, 2)->nullable();
            $table->decimal('bonus_price', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_model_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('source'); // ventas, dyp, etc.
            $table->string('rut')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('vehicle_id')->nullable();
            $table->string('service_type')->nullable(); // Para DyP o Servicio Técnico
            $table->text('message')->nullable();
            $table->json('raw_request')->nullable(); // Para persistencia total del lead
            $table->boolean('crm_synced')->default(false);
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image_desktop');
            $table->string('image_mobile');
            $table->string('link')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->float('lat', 10, 6)->nullable();
            $table->float('lng', 10, 6)->nullable();
            $table->text('opening_hours')->nullable();
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('features');
        Schema::dropIfExists('vehicle_versions');
        Schema::dropIfExists('vehicle_models');
        Schema::dropIfExists('brands');
    }
};
