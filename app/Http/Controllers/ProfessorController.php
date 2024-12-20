<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfessorController extends Controller
{
    // Método para exibir a lista de projetos com funcionalidade de busca
    public function index(Request $request)
{
    // Captura a query de busca se existir
    $search = $request->input('search');

     // Busca os projetos no banco de dados, aplicando filtros para título ou nome do aluno
     $projetos = Projeto::when($search, function ($query, $search) {
        return $query->where('titulo', 'like', "%{$search}%")
                     ->orWhereHas('aluno', function ($q) use ($search) {
                         $q->where('nome', 'like', "%{$search}%");
                     });
    })->get();
    

    // Retorna a view 'GerenciarProjetos' com os dados dos projetos
    return Inertia::render('Professor/GerenciarProjetos', [
        'projetos' => $projetos->map(function ($projeto) {
            return [
                'id' => $projeto->id,
                'titulo' => $projeto->titulo,
                'nomeAluno' => $projeto->aluno->nome ?? 'Não associado',
                'nota' => $projeto->nota, // Adicione a nota aqui
            ];
        }),
    ]);     
}

public function avaliarProjeto(Request $request, $id)
{
    $request->validate([
        'nota' => 'required|numeric|min:0|max:10',
    ]);

    $projeto = Projeto::findOrFail($id);
    $projeto->nota = $request->input('nota');
    $projeto->save();

    return redirect()->back()->with('success', 'Nota atualizada com sucesso.');
}


    // Método para exibir um projeto específico para avaliação
    public function show($id)
    {
        // Busca o projeto pelo ID ou retorna erro 404 se não encontrado
        $projeto = Projeto::findOrFail($id);

        // Retorna a view 'AvaliarProjeto' com os dados do projeto
        return Inertia::render('Professor/AvaliarProjeto', [
            'projeto' => $projeto,
        ]);
    }
}
