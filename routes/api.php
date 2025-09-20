<?php

use App\Http\Controllers\Api\EmpresasController;
use Illuminate\Support\Facades\Route;

Route::get('/empresas', [EmpresasController::class, 'index']);