<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    // Método para exibir o projeto do aluno
    public function show($id)
    {
        // Busca o projeto pelo ID ou retorna erro 404 se não encontrado
        $projeto = Projeto::findOrFail($id);

        // Retorna a view 'Projeto' com os dados do projeto
        return Inertia::render('Aluno/Projeto', [
            'projeto' => $projeto,
        ]);
    }

    // Método para criar um novo projeto (renderiza o formulário)
    public function create()
    {
        return Inertia::render('Aluno/CriarProjeto');
    }

    // Método para salvar o novo projeto
    public function store(Request $request)
{
    // Validação dos dados
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descricao' => 'required|string',
        'data_inicio' => 'required|date',
        'data_conclusao' => 'required|date|after_or_equal:data_inicio',
    ]);

    // Criação do novo projeto
    $projeto = Projeto::create([
        'titulo' => $request->titulo,
        'descricao' => $request->descricao,
        'data_inicio' => $request->data_inicio,
        'data_conclusao' => $request->data_conclusao,
    ]);

    // Redireciona o aluno para a página inicial do aluno com uma mensagem de sucesso
    return redirect()->route('aluno.home')->with('success', 'Projeto criado com sucesso!');
}
}