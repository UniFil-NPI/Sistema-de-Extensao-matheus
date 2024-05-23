<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function loginProfessor(Request $request)
    {
        // Redireciona diretamente para a página ProfessorHome
        return redirect()->route('professorHome');
    }
}

