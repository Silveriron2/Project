<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('home', [DashboardController::class, 'dashboard']);

Route::get('/profile', [loginController::class, 'profile']);

// Home //
Route::get('/users-home', [HomeController::class, 'index']);
Route::get('/users-broadcast', [PusherController::class, 'broadcast']);
Route::get('/users-receive', [PusherController::class, 'receive']);

// User //
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::get('/users/{id}/edit', [UserController::class, 'edit']);

Route::get('/profile', [UserController::class, 'profile'])->name('profile');

// Pusher //
Route::get('/', [PusherController::class, 'index']);
Route::get('/broadcast', [PusherController::class, 'broadcast']);
Route::get('/receive', [PusherController::class, 'receive']);





