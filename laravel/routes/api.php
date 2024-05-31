<?php

use App\Http\Controllers\loginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User // 
Route::get('/userList', [UserController::class, 'userList']);
Route::post('/users/create', [UserController::class, 'createUser']);
Route::get('/users/{id}', [UserController::class, 'getUserId']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);
Route::delete('/delete/users/{id}', [UserController::class, 'deleteUser']);

Route::post('verifyOTP',[loginController::class,'verifyOTP']);
Route::post('/login', [UserController::class, 'login']);

