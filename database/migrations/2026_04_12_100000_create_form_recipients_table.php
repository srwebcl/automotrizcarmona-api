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
        if (Schema::hasTable('form_recipients')) {
            // Already created, do nothing or just attempt insert
            // To ensure we don't duplicate, we return.
            return;
        }

        Schema::create('form_recipients', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique(); // 'contacto', 'reclamos', 'dyp'
            $table->string('name');
            $table->json('emails')->nullable();
            $table->timestamps();
        });

        if (DB::table('form_recipients')->count() === 0) {
            // Insert default data
            DB::table('form_recipients')->insert([
                [
                    'identifier' => 'contacto',
                    'name' => 'Formulario de Contacto general',
                    'emails' => json_encode(['contacto@carmonaycia.cl']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'identifier' => 'reclamos',
                    'name' => 'Reclamos y Sugerencias',
                    'emails' => json_encode(['contacto@carmonaycia.cl']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'identifier' => 'dyp',
                    'name' => 'Cotizar Desabolladura y Pintura',
                    'emails' => json_encode(['calldyp@carmonaycia.cl']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('form_recipients');
    }
};
