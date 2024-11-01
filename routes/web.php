<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisteredUserController;
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

// Rota de registro para alunos utilizando o RegisteredUserController
Route::get('/registerAluno', [RegisteredUserController::class, 'create'])->name('registerAluno');
Route::post('/registerAluno', [RegisteredUserController::class, 'store'])->name('registerAluno.post');

// Rotas de autenticação
Route::get('/loginProfessor', function () {
    return Inertia::render('LoginProfessor');
})->name('loginProfessor'); 

Route::post('/loginProfessor', [LoginController::class, 'loginProfessor'])->name('loginProfessor.post');

// Rota aluno Entry
Route::get('/alunoEntry', [AlunoController::class, 'showAlunoEntry'])->name('aluno.entry');

//rota de listar alunos
Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');

//rota update dados aluno
Route::put('/alunos/{id}', [AlunoController::class, 'update']);


Route::get('/projetoAluno', function () {
    return view('projetoAluno');
});


// Login para alunos
Route::get('/loginAluno', function () {
    return Inertia::render('LoginAluno');
})->name('loginAluno');

Route::post('/loginAluno', [AlunoController::class, 'login'])->name('loginAluno.post');

// Rota para a tela inicial do aluno (protegida por middleware de autenticação)
Route::get('/alunoHome', function () {
    return Inertia::render('AlunoHome');
})->name('alunoHome');

// Rota para o aluno criar um projeto
Route::get('/aluno/criar-projeto', [ProjetoController::class, 'create'])->name('projetos.create');

// Rota para armazenar o projeto
Route::post('/aluno/projetos', [ProjetoController::class, 'store'])->name('projetos.store');

// Rotas protegidas para professores (admin)
Route::get('/professorHome', function () {
    return Inertia::render('ProfessorHome');
})->name('professorHome');

// Rota para exibir a lista de projetos com funcionalidade de busca
Route::get('/professor/projetos', [ProfessorController::class, 'index'])->name('professor.projetos');

// Rota para exibir um projeto específico para avaliação
Route::get('/professor/projetos/{id}', [ProfessorController::class, 'show'])->name('professor.projetos.show');

// Rota para o aluno visualizar o próprio projeto
Route::get('/aluno/projeto/{id}', [ProjetoController::class, 'show'])->name('aluno.projeto.show');

//salvar alterações do projeto
Route::put('/aluno/projeto/{id}', [ProjetoController::class, 'update'])->name('projeto.update');


// Rotas de atividades para o professor gerenciar
Route::get('/atividades', [AtividadeController::class, 'index']);
Route::post('/atividades', [AtividadeController::class, 'store']);
Route::post('/atividades/{id}/submeter-link', [AtividadeController::class, 'submeterLink']);

// Rota de recuperação de senha para alunos
Route::get('/forgotPasswordAluno', function () {
    return Inertia::render('ForgotPasswordAluno'); 
})->name('forgotPasswordAluno');

// Rota para gerenciamento de projetos (apenas admin)
Route::get('/gerenciarProjetos', function () {
    return Inertia::render('Professor/GerenciarProjetos');
})->name('gerenciarProjetos');
