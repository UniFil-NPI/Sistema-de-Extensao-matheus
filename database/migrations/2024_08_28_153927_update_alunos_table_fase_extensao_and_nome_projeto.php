<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAlunosTableFaseExtensaoAndNomeProjeto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropColumn('matricula'); // Remove o campo 'matricula'
            $table->integer('faseExtensao')->after('email'); // Adiciona o campo 'faseExtensao'
            $table->string('nomeProjeto')->after('faseExtensao'); // Adiciona o campo 'nomeProjeto'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('matricula')->after('email'); // Reverte o campo 'matricula'
            $table->dropColumn('faseExtensao'); // Remove o campo 'faseExtensao'
            $table->dropColumn('nomeProjeto'); // Remove o campo 'nomeProjeto'
        });
    }
}
