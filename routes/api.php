<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\UserTasksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [LoginController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('tasks', TaskController::class);

    Route::post('/task/assign/{taskId}', [TaskAssignmentController::class, 'assignUser']);
    Route::delete('/task/unassign/{taskId}', [TaskAssignmentController::class, 'unassignUser']);
    Route::put('/task/status/{taskId}', [TaskAssignmentController::class, 'updateStatus']);

    Route::get('/user/{userId}/tasks', [UserTasksController::class, 'UserTasks']);
    Route::get('/user/tasks', [UserTasksController::class, 'loggedUserTasks']);
});
