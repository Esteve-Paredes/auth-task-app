<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ProjectController;
use App\Http\Controllers\api\TaskController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api'
],function ($router) 
{
    //rutas para registrar un usuario
    Route::post('/register', [AuthController::class, 'register']);
    
    //ruta para iniciar sesion
    Route::post('/login', [AuthController::class, 'login']);

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        
        //rutas para el usuario
        Route::get('/user', [AuthController::class, 'userProfile']);
    
        //rutas para proyectos
        Route::get('/projects', [ProjectController::class, 'index']);
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::get('/projects/{id}', [ProjectController::class, 'show']);
        Route::put('/projects/{id}', [ProjectController::class, 'update']);
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
        
        //rutas para tareas
        Route::get('/projects/{projectId}/tasks', [TaskController::class, 'index']);
        Route::post('/projects/{projectId}/tasks', [TaskController::class, 'store']);
        Route::get('/projects/{projectId}/tasks/{taskId}', [TaskController::class, 'show']);
        Route::put('projects/{projectId}/tasks/{taskId}', [TaskController::class, 'update']);
        Route::delete('projects/{projectId}/tasks/{taskId}', [TaskController::class, 'destroy']);
    });
    
});


