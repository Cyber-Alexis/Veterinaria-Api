<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DuenoController;
use App\Http\Controllers\Api\AnimalController;

// Rutas para Dueños
Route::apiResource('duenos', DuenoController::class);

// Rutas para Animales
Route::apiResource('animales', AnimalController::class);