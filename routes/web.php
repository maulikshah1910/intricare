<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('users/', [UserController::class, 'index'])->name('home');
Route::post('users/browse', [UserController::class, 'browse'])->name('users.browse');
Route::post('users/store', [UserController::class, 'store'])->name('users.store');
Route::post('users/destroy', [UserController::class, 'destroy'])->name('users.destroy');
Route::any('users/{id}', [UserController::class, 'show'])->name('users.info');
