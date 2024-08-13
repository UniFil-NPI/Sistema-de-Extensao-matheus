<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividade;
use Carbon\Carbon;

class AtividadeController extends Controller
{
    public function index()
    {
        // Retorna apenas as atividades com data de entrega a partir de hoje
        $atividades = Atividade::where('dataEntrega', '>=', Carbon::today()->toDateString())->get();
        return response()->json($atividades);
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