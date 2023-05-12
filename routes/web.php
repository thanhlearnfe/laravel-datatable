<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController; //
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
use App\Http\Controllers\UsersController;
 
Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::get('/', [CustomersController::class, 'index']);
Route::get('ajaxdata', [CustomersController::class, 'getdata'])->name('getdata');