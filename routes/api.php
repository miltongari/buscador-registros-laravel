<?php

use App\Http\Controllers\Api\EmpresasController;

Route::get('/empresas', [EmpresasController::class, 'index']);
