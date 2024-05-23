<?php

use App\Http\Controllers\AlunoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/alunos', [AlunoController::class, 'index']);
Route::get('/alunos', [AlunoController::class, 'index']);