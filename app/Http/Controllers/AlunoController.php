<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

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

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $aluno = Aluno::where('email', $request->email)->first();

    if ($aluno && Hash::check($request->password, $aluno->password)) {
        Auth::login($aluno);
        return redirect()->route('alunoHome');
    } else {
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }   
}
    public function showAlunoEntry()
    {
        return Inertia::render('AlunoEntry'); // Certifique-se de que o caminho do componente Vue está correto
    }
}


