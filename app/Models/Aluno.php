<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Herda de Authenticatable para autenticação
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Aluno extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $table = 'alunos';  // Define a tabela correta

    protected $fillable = [
        'nome', 'email','password', 'faseExtensao', 'nomeProjeto',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    //public function setPasswordAttribute($value)
    //{
    //    $this->attributes['password'] = Hash::make($value);
    //}
    public function projeto()
{
    return $this->hasOne(Projeto::class, 'aluno_id');
}
}