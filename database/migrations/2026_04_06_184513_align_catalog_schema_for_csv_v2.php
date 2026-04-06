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
        Schema::table('vehicle_versions', function (Blueprint $table) {
            // Guardarraíl 1: Limpiar los Decimal antiguos y usar BigInteger puros
            $table->dropColumn(['list_price', 'bonus_price']);

            // Guardarraíl 2: Amigables SEO (Slugs)
            $table->string('slug')->unique()->after('name')->nullable();

            // Rellenar las variables monetarias seguras
            $table->unsignedBigInteger('list_price')->nullable()->after('fuel');
            $table->unsignedBigInteger('brand_bonus')->nullable();
            $table->unsignedBigInteger('finance_bonus')->nullable();
            $table->unsignedBigInteger('finance_price')->nullable();

            // Adicionales Técnicos (CSV)
            $table->boolean('includes_iva')->default(true);
            $table->string('engine')->nullable();
            $table->integer('airbags')->nullable();
            $table->string('mixed_performance')->nullable();
            $table->string('autonomy_km')->nullable();
            $table->string('power_hp')->nullable();
            $table->string('torque_nm')->nullable();

            // Guardarraíl 3: Soft Deletes
            $table->softDeletes();
        });

        // Aseguramos el borrado lógico también en marcas y modelos
        Schema::table('brands', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('vehicle_models', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_versions', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'slug', 'list_price', 'brand_bonus', 'finance_bonus', 'finance_price',
                'includes_iva', 'engine', 'airbags', 'mixed_performance',
                'autonomy_km', 'power_hp', 'torque_nm'
            ]);
            $table->decimal('list_price', 15, 2)->nullable();
            $table->decimal('bonus_price', 15, 2)->nullable();
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('vehicle_models', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
