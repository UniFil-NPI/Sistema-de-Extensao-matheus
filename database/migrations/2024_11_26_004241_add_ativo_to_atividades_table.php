<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAtivoToAtividadesTable extends Migration
{
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->boolean('ativo')->default(true); // Adiciona o campo 'ativo' com valor padrão true
        });
    }

    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->dropColumn('ativo'); // Remove o campo 'ativo'
        });
    }
}
