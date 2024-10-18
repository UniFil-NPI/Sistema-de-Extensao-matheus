<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterAlunoController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Dados recebidos no controlador de registro:', $request->all());
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos,email',
            'password' => 'required|string|min:8', 
            'faseExtensao' => 'required|integer|min:1|max:4',
            'nomeProjeto' => 'required|string|max:255',
        ]);
        Aluno::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'faseExtensao' => $request->faseExtensao,
            'nomeProjeto' => $request->nomeProjeto,
        ]);
        // Adiciona um log para confirmar que o aluno foi criado com sucesso
        Log::info('Aluno registrado com sucesso:', ['aluno_id' => $aluno->id]);
        return redirect()->route('alunoHome');
    } 
}