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

        // Busca os projetos no banco de dados, aplicando filtro de busca se necessário
        $projetos = Projeto::when($search, function ($query, $search) {
            return $query->where('titulo', 'like', "%{$search}%");
        })->get();

        // Retorna a view 'GerenciarProjetos' com os dados dos projetos
        return Inertia::render('Professor/GerenciarProjetos', [
            'projetos' => $projetos,
            'search' => $search,
        ]);
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
