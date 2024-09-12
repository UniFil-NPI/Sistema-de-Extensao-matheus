<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário logado é admin (você pode basear isso em um campo 'role' no banco de dados)
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        // Se não for admin, redireciona para uma página de erro ou para a home
        return redirect('/');
    }
}