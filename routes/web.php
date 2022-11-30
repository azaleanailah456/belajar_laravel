<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registerController;
use App\Http\Controllers\loginController;

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

Route::middleware('isGuest')->group(function (){
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::get('/register', [LoginController::class, 'register']);

    Route::post('/register', [LoginController::class, 'inputRegister'])->name('register.post');
    Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');
    Route::post('/login', [LoginController::class, 'index'])->name('todo.index');

    Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//todo
Route::middleware('isLogin')->prefix('/todo')->name('todo.')->group(function (){
    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::get('/complated', [LoginController::class, 'complated'])->name('complated');
    Route::get('/create', [LoginController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [LoginController::class, 'edit'])->name('edit');
    Route::post('/store', [LoginController::class, 'store'])->name('store');
    Route::patch('/update/{id}', [LoginController::class, 'update'])->name('update');

    Route::delete('/delete/{id}', [LoginController::class, 'destroy'])->name('delete');
    Route::patch('/complated/{id}', [LoginController::class, 'updateComplated'])->name('updateComplated');


});

// href= "{{route('todo.complated')}}"