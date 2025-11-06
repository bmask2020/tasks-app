<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\CommentsController;
use App\Http\Middleware\CheckTaskOwnership;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');


    // Auth Api End Point
    Route::controller(ApiController::class)->group(function () {
        Route::any('register', 'register');
        Route::any('login', 'login');
        Route::any('logout', 'logout');
    });


    Route::middleware(['auth:sanctum'])->group(function () {

        // Protected Task Api End Point
        Route::controller(TasksController::class)->group(function () {
            Route::get('tasks', 'all_tasks');
            Route::any('tasks/store', 'tasks_store');
            Route::get('tasks/{id}', 'tasks_view');
        
            Route::put('tasks/update', 'tasks_update')->middleware(CheckTaskOwnership::class);
            Route::delete('tasks/delete', 'tasks_delete')->middleware(CheckTaskOwnership::class);
            
            Route::get('task/search', 'tasks_search');
            Route::any('tasks/status/{status}',  'tasks_status');
        });  

    }); 


    // Commints Api End Point
    Route::controller(CommentsController::class)->group(function () {

        Route::any('tasks/{id_task}/comment/store', 'tasks_comment_store')->middleware('auth:sanctum');
        Route::any('tasks/{id_task}/comments', 'tasks_comments');
        
    });  

 
