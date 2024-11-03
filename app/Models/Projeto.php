<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    // Defina os campos que podem ser preenchidos
    protected $fillable = ['titulo', 'descricao','dataInicio','dataFim','objetivos','tecnologias','cronograma','informacoes_avulsas'];

    public function aluno()
{
    return $this->belongsTo(Aluno::class, 'aluno_id');
}
    
}

