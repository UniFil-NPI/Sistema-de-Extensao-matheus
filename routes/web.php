<?php

use Illuminate\Support\Facades\Route;

// Rota para a página inicial
Route::get('/', function () {
    return view('home');
});

// Rota para a página de cadastro de aluno
Route::get('/CadastroAluno', function () {
    return view('CadastroAluno');
})->name('CadastroAluno');

// Rota para a página de login do professor
Route::get('/login-professor', function () {
    return view('login-professor');
})->name('login-professor');

// Rota para submissão do formulário de login do professor
Route::post('/login-professor-submit', [ProfessorLoginController::class, 'login'])->name('login.professor.submit');
