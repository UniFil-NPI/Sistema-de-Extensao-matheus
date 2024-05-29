<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RegisterAlunoController;
use App\Http\Controllers\AlunoController;

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

Route::post('/loginProfessor', [LoginController::class, 'loginProfessor'])->name('loginProfessor.post');

// Nova rota para a página ProfessorHome
Route::get('/professorHome', function () {
    return Inertia::render('ProfessorHome');
})->name('professorHome');

// Rota de registro para alunos
Route::get('/registerAluno', function () {
    return Inertia::render('registerAluno');
})->name('registerAluno');
Route::post('/register/aluno', [RegisterAlunoController::class, 'store'])->name('RegisterAluno.store');

// Rota para buscar alunos
Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');

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

Route::get('/alunos', [AlunoController::class, 'index']);
Route::get('/alunos/{id}', [AlunoController::class, 'show']);
Route::put('/alunos/{id}', [AlunoController::class, 'update']);

require __DIR__.'/auth.php';
