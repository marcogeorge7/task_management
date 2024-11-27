<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::prefix('projects')->group(function () {
    Route::post('/', [ProjectController::class, 'store']);
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/{id}', [ProjectController::class, 'show']);
});

Route::prefix('tasks')->group(function () {
    Route::post('/', [TaskController::class, 'store']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::post('/{id}/dependencies', [TaskController::class, 'addDependency']);
    Route::delete('/{id}/dependencies/{dependencyId}', [TaskController::class, 'removeDependency']);
    Route::get('/search', [TaskController::class, 'search']);
});

