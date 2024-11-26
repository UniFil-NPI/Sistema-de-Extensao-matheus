<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividade;
use Carbon\Carbon;

class AtividadeController extends Controller
{
    public function index()
    {
        // Retorna apenas atividades ativas
    $atividades = Atividade::ativas()->where('dataEntrega', '>=', now()->toDateString())->get();
    return response()->json($atividades);
    }

    public function destroy($id)
{
    $atividade = Atividade::findOrFail($id);
    $atividade->update(['ativo' => false]); // Atualiza o campo 'ativo' para false
    return response()->json(['message' => 'Atividade ocultada com sucesso.'], 200);
}


public function update(Request $request, $id)
{
    $atividade = Atividade::findOrFail($id);

    $request->validate([
        'titulo' => 'required|string|max:255',
        'descricao' => 'required|string',
        'dataEntrega' => 'required|date|after_or_equal:today',
    ]);

    $atividade->update($request->only('titulo', 'descricao', 'dataEntrega'));

    return response()->json($atividade, 200);
}


    public function store(Request $request)
    {
        // Valida se a data de entrega é a partir de hoje
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'dataEntrega' => 'required|date|after_or_equal:today',
        ]);

        // Cria a atividade se a validação passar
        $atividade = Atividade::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'dataEntrega' => $request->dataEntrega,
            'concluida' => false,  // Defina como false por padrão
            'link' => null, // Pode ser nulo até o aluno submeter
        ]);

        return response()->json($atividade, 201);
    }
 

    public function submeterLink(Request $request, $id)
    {
        $atividade = Atividade::findOrFail($id);

        // Atualiza o status da atividade e o link fornecido
        $atividade->update([
            'concluida' => true,
            'link' => $request->input('link')
        ]);

        return response()->json($atividade, 200);
    }
}