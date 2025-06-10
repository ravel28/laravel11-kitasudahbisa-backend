<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\PositionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// USER MODULE
Route::post('/users/create', [UserController::class, 'createUser']);
Route::post('/users/login', [UserController::class, 'checkUserAccount']);
Route::get('/users/{take}', [UserController::class,'index']);
Route::get('/users/finding/{id}', [UserController::class, 'checkUserAccountById']);
Route::put('/users/update/{id}', [UserController::class, 'updateUser']);
Route::delete('/users/delete/{id}', [UserController::class, 'deleteUser']);

// DIVISION MODULE
Route::get('/divisions/{take}', [DivisionController::class,'index']);
Route::post('/divisions/create', [DivisionController::class, 'createDivision']);
Route::put('/divisions/update/{id}', [DivisionController::class, 'updateDivision']);
Route::delete('/divisions/delete/{id}', [DivisionController::class, 'deleteDivision']);

// POSITION MODULE
Route::get('/positions/{take}', [PositionController::class,'index']);
Route::post('/position/create', [PositionController::class, 'createPosition']);
Route::put('/position/update/{id}', [PositionController::class, 'updatePosition']);
Route::delete('/position/delete/{id}', [PositionController::class, 'deletePosition']);