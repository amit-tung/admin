<?php

use App\Http\Controllers\adminpanel\DashboardController;
use App\Http\Controllers\adminpanel\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

Route::get('/users', [UserController::class,'index'])->name('users.index');
Route::get('/users/create', [UserController::class,'create'])->name('users.create');
Route::post('/users/store', [UserController::class,'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class,'index'])->name('users.edit');

Route::middleware(['auth'])->group(function () {

    
    Route::get('/logout', [DashboardController::class,'index'])->name('logout');

});