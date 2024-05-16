<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; // Certifique-se de importar o modelo Student

class StudentController extends Controller
{
    public function search(Request $request)
    {
        // Receber o termo de busca do formulário
        $searchTerm = $request->input('search');

        // Realizar a consulta utilizando o Eloquent ORM
        $students = Student::where('name', 'LIKE', "%$searchTerm%")->get();

        // Retornar os resultados para a view
        return view('students.search_results', ['students' => $students]);
    }
}
