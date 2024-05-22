<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class RegisterAlunoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:alunos,email',
            'ddd' => 'required|string|max:3',
            'telefone' => 'required|string|max:15',
            'tipoExtensao' => 'required|string|max:255',
        ]);

        $user = Aluno::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'ddd' => $request->ddd,
            'telefone' => $request->telefone,
            'tipoExtensao' => $request->tipoExtensao,
        ]);
        
        //return redirect()->route('registerAluno')->with('success', 'Aluno cadastrado com sucesso!');
        return response()->json(['message' => 'Aluno cadastrado com sucesso!']);

    }
}
