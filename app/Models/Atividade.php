<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;

    // Defina os campos que podem ser preenchidos
    protected $fillable = [
        'titulo',
        'descricao',
        'dataEntrega',
        'concluida',
        'created_at',
        'updated_at',
        'link',
        'ativo',
    ];

    // Defina os valores padrão para campos não obrigatórios
    protected $attributes = [
        'concluida' => false,
    ];

    public function scopeAtivas($query)
{
    return $query->where('ativo', true);
}

}
