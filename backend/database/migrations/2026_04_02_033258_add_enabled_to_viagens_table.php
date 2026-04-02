<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('viagens', function (Blueprint $table) {
            // Por padrão, toda viagem nasce habilitada (1)
            $table->boolean('enabled')->default(1)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('viagens', function (Blueprint $table) {
            //
        });
    }
};
