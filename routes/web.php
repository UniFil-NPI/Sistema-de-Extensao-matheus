<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RegisterAlunoController;

// Rota principal
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Rota de login para professores
Route::get('/loginProfessor', function () {
    return Inertia::render('LoginProfessor');
})->name('loginProfessor');

Route::post('/login/professor', [LoginController::class, 'loginProfessor'])->name('loginProfessor.post');

// Nova rota para a página ProfessorHome
Route::get('/professor/home', function () {
    return Inertia::render('ProfessorHome');
})->middleware(['auth'])->name('professorHome');

// Rota de registro para alunos
Route::get('/registerAluno', function () {
    return Inertia::render('registerAluno');
})->name('registerAluno');
Route::post('/register/aluno', [registerAlunoController::class, 'store'])->name('RegisterAluno.store');

// Rota do dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
