<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterAlunoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos,email',
            'faseExtensao' => 'required|string|max:15',
            'nomeProjeto' => 'required|string|max:255',
        ]);

        Aluno::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'faseExtensao' => $request->faseExtensao,
            'nomeProjeto' => $request->nomeProjeto,
        ]);

        return redirect()->route('alunoHome');
    }
}
