<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APITasksController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('task',[APITasksController::class,'create']);
Route::get('task',[APITasksController::class, 'index']);  // Corrected from ger to get
Route::get('task/{id}',[APITasksController::class, 'getTaskByID']);
Route::put('task/{id}',[APITasksController::class, 'update']);
Route::post('task/done/{id}',[APITasksController::class, 'markAsDone']);
Route::delete('task/{id}',[APITasksController::class, 'delete']);
Route::put('/task/done/{id}', [APITasksController::class, 'markAsDone']);

