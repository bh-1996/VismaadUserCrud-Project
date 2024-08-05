<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('showRegistrationForm');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Routes requiring authentication with 'user' prefix
Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');
    Route::get('/edit-profile/{id}', [UserController::class, 'editProfile'])->name('editProfile');
    Route::post('/update-profile/{id}', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/lists', [UserController::class, 'users'])->name('users');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});


