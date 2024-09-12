<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->default('Sem título');
            $table->text('descricao')->nullable();
            $table->date('dataInicio');
            $table->date('dataFim')->nullable();
            //$table->foreignId('aluno_id')->constrained('alunos')->onDelete('cascade');
            $table->string('aluno_id')->default('1');//quando for autenticar colocar email(é a primary key)e rodar a migration denovo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projetos');
    }
}
