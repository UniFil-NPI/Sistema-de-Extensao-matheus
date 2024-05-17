<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Rota para processar a escolha do usuário
Route::post('/choose-role', function (Request $request) {
    // Obtenha a escolha do usuário (aluno ou professor) do formulário
    $role = $request->input('role');

    // Redirecione com base na escolha do usuário
    if ($role === 'aluno') {
        return redirect()->route('cadastro-aluno');
    } elseif ($role === 'professor') {
        return redirect()->route('login-professor');
    }   
})->name('choose-role');


Route::get('/login/professor', function () {
    return Inertia::render('LoginProfessor');
})->name('loginProfessor');

Route::get('/register/aluno', function () {
    return Inertia::render('RegisterAluno');
})->name('registerAluno');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
