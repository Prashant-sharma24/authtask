<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\CustomMiddleware;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Use showLoginForm here
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['custom'])->group(function () {
    Route::get('/dashboard', [UsersController::class, 'showUsersList'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/users/data', [UsersController::class, 'getUsersData'])->name('users.data');
    Route::get('/users/{id}/edit', 'UsersController@edit')->name('users.edit');
    Route::delete('/users/{id}', 'UsersController@destroy')->name('users.destroy');


    Route::delete('/users/{id}', [UsersController::class, 'destroy']);
});
// Route::get('/users/data', [UsersController::class, 'getUsersData'])->name('users.data');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register']);
