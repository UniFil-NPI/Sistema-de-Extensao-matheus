<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RegisterAlunoController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AtividadeController; // Adicionado

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

// Rota para a tela inicial do aluno 
Route::get('/alunoHome', function () {
    return Inertia::render('AlunoHome');
})->name('alunoHome');

// Rota para buscar alunos
Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');
Route::get('/alunos/{id}', [AlunoController::class, 'show']);
Route::put('/alunos/{id}', [AlunoController::class, 'update']);

// Rotas de atividade
Route::get('/atividades', [AtividadeController::class, 'index']);
Route::post('/atividades', [AtividadeController::class, 'store']);
Route::post('/atividades/{id}/submeter-link', [AtividadeController::class, 'submeterLink']);

// Rota do dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil
Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware('auth')->name('profile.destroy');
