<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::all();
        return response()->json($alunos);
    }
    public function show($id)
    {
        $aluno = Aluno::findOrFail($id);
        return response()->json($aluno);
    }

    public function update(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update($request->all());
        return response()->json($aluno);
    }
}

