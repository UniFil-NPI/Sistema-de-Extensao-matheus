<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está autenticado e se ele é um admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Caso o usuário não seja admin ou não esteja autenticado, redireciona
        return redirect('/login')->with('error', 'Você não tem permissão para acessar esta página.');
    }
    protected $routeMiddleware = [
        // Outros middlewares
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}