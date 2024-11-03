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
        
        // Validação dos dados de entrada
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos,email',
            'password' => 'required|string|min:8|confirmed', // Certifique-se de que a confirmação de senha está aqui
            'faseExtensao' => 'required|integer|min:1|max:4',
            'nomeProjeto' => 'required|string|max:255',
        ]);
        
        // Criação do aluno
        $aluno = Aluno::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'faseExtensao' => $request->faseExtensao,
            'nomeProjeto' => $request->nomeProjeto,
        ]);

        // Cria um projeto e associa ao aluno
    $projeto = Projeto::create([
        'nomeProjeto' => $request->nomeProjeto,
        'aluno_id' => $aluno->id, // Associa o projeto ao aluno pelo ID
    ]);
        // Log para confirmar que o aluno foi criado com sucesso
        Log::info('Aluno registrado com sucesso:', ['aluno_id' => $aluno->id]);

        // Redireciona o aluno para a página inicial ou onde você desejar
        return redirect()->route('alunoHome');
    }
}
