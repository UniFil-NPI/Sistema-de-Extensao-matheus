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
    // Valida as credenciais de entrada
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Tente encontrar o aluno pelo email
    $aluno = Aluno::where('email', $request->email)->first();

    // Verifique se o aluno foi encontrado e se a senha está correta
    if ($aluno && Hash::check($request->password, $aluno->password)) {
        Auth::guard('alunos')->login($aluno); // Use o guard 'alunos'
        return redirect()->route('alunoHome');
    } else {
        // Se a autenticação falhar, redireciona de volta com um erro
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }
}
    public function showAlunoEntry()
    {
        return Inertia::render('AlunoEntry'); // Certifique-se de que o caminho do componente Vue está correto
    }

    public function home(Request $request)
    {
        // Obtenha o aluno autenticado usando o guard 'alunos'
        $aluno = Auth::guard('alunos')->user();

        // Verifique se o aluno está autenticado
        if (!$aluno) {
            return redirect()->route('loginAluno')->withErrors('Você precisa estar logado para acessar essa página.');
        }

        // Renderize a view 'AlunoHome' com os dados do aluno
        return Inertia::render('AlunoHome', [
            'aluno' => $aluno,
        ]);
    }

}


