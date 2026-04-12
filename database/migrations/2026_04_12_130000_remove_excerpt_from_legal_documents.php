<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('legal_documents', function (Blueprint $table) {
            if (Schema::hasColumn('legal_documents', 'excerpt')) {
                $table->dropColumn('excerpt');
            }
        });
    }

    public function down(): void
    {
        Schema::table('legal_documents', function (Blueprint $table) {
            if (!Schema::hasColumn('legal_documents', 'excerpt')) {
                $table->text('excerpt')->nullable();
            }
        });
    }
};
