<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->string('link')->nullable(); // Adicione o campo `link`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->dropColumn('link'); // Remova o campo `link` se necessário
        });
    }
};
