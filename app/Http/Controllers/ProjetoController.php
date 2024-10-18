<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjetoController extends Controller
{
    // Método para exibir o projeto do aluno
    public function show($id)
    {
        $aluno_id = 1;
        //$aluno_id = Auth::id();
        // Busca o projeto pelo ID ou retorna erro 404 se não encontrado
        //$projeto = Projeto::findOrFail($id);
        $projeto = Projeto::where('id', $id)->where('aluno_id', $aluno_id)->firstOrFail();

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
    $validatedData = $request->validate([
        'titulo' => 'required|string|max:255',
        'descricao' => 'required|string',
        'dataInicio' => 'required|date',
        'dataFim' => 'required|date|after_or_equal:dataInicio   ',
    ]);
    // Mapeia dataFim para dataFim antes de salvar no banco
    //$validatedData['dataFim'] = $validatedData['dataFim'];
    //unset($validatedData['dataFim']);

    
    // Temporariamente definindo um aluno_id padrão
    $aluno_id = '1'; // Ajuste este valor conforme necessário

    //\DB::table('projetos')->insert(array_merge($validatedData, ['aluno_id' => $aluno_id]));    
    // Criação do novo projeto
    $projeto = Projeto::create([
        'titulo' => $request->titulo,
        'descricao' => $request->descricao,
        'dataInicio' => $request->dataInicio,
        'dataFim' => $request->dataFim,
        'aluno_id' => $aluno_id, // Valor temporário até que o login esteja implementado
    ]);
    
    // Redireciona o aluno para a página inicial do aluno com uma mensagem de sucesso
    return redirect()->route('projeto.show', $projeto->id)->with('success', 'Projeto criado com sucesso!');
}
}