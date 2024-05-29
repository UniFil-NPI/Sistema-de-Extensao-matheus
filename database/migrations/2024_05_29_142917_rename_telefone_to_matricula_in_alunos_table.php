<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->renameColumn('telefone', 'matricula');
        });
    }

    public function down()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->renameColumn('matricula', 'telefone');
        });
    }
};
