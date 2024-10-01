<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário logado é admin (você pode basear isso em um campo 'role' no banco de dados)
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Se não for admin, redireciona para uma página de erro ou para a home
        return redirect('/loginAluno')->with('error','Você não tem permissão para acessar está area');
    }
}