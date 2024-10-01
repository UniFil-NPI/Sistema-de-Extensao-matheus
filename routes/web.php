<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RegisterAlunoController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AtividadeController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\ProfessorController;



// Rota principal
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Rotas de autenticação
Route::get('/loginProfessor', function () {
    return Inertia::render('LoginProfessor');
})->name('loginProfessor');

Route::post('/loginProfessor', [LoginController::class, 'loginProfessor'])->name('loginProfessor.post');

//Rota aluno Entry
Route::get('/alunoEntry', [AlunoController::class, 'showAlunoEntry'])->name('aluno.entry');

// Login para alunos
Route::get('/loginAluno', function () {
    return Inertia::render('LoginAluno');
})->name('loginAluno');

Route::post('/loginAluno', [AlunoController::class, 'login'])->name('loginAluno.post');

// Rota de registro para alunos
Route::get('/registerAluno', function () {
    return Inertia::render('RegisterAluno');
})->name('registerAluno');

Route::post('/register/aluno', [RegisterAlunoController::class, 'store'])->name('RegisterAluno.store');

// Rota para a tela inicial do aluno (protegida por middleware de autenticação)
Route::middleware(['auth'])->group(function () {
    Route::get('/alunoHome', function () {
        return Inertia::render('AlunoHome');
    })->name('alunoHome');

    // Rota para o aluno criar um projeto
    Route::get('/aluno/criar-projeto', function () {
        return Inertia::render('Aluno/CriarProjeto');
    });

    Route::post('/aluno/projetos', [ProjetoController::class, 'store'])->name('projetos.store');

    // Rota do perfil de usuário autenticado
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware('auth')->name('profile.destroy');
});

// Rotas protegidas para professores (admin)
Route::middleware(['auth'])->group(function () {
    // Nova rota para a página ProfessorHome
    Route::get('/professorHome', function () {
        return Inertia::render('ProfessorHome');
    })->name('professorHome');

    // Rota para exibir a lista de projetos com funcionalidade de busca
    Route::get('/professor/projetos', [ProfessorController::class, 'index'])->name('professor.projetos');

    // Rota para exibir um projeto específico para avaliação
    Route::get('/professor/projetos/{id}', [ProfessorController::class, 'show'])->name('professor.projetos.show');

    // Rotas de atividades para o professor gerenciar
    Route::get('/atividades', [AtividadeController::class, 'index']);
    Route::post('/atividades', [AtividadeController::class, 'store']);
    Route::post('/atividades/{id}/submeter-link', [AtividadeController::class, 'submeterLink']);
});

// Rota de recuperação de senha para alunos
Route::get('/forgotPasswordAluno', function () {
    return Inertia::render('ForgotPasswordAluno'); 
})->name('forgotPasswordAluno');

// Rota para gerenciamento de projetos (apenas admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/gerenciarProjetos', function () {
        return Inertia::render('Professor/GerenciarProjetos');
    })->name('gerenciarProjetos');
});

// Rota de dashboard protegida
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');