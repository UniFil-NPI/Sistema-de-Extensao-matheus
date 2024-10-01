<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginProfessor(Request $request)
    {
        // Validação das credenciais
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentativa de login com as credenciais fornecidas
        if (Auth::attempt(array_merge($credentials, ['is_admin' => 1]))) {
            // Redirecionar para a home do professor após login bem-sucedido
            return redirect()->route('professorHome');
        }
        

        // Se o login falhar, retornar com mensagem de erro
        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }
}


