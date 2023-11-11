<?php

use App\Http\Controllers\ContatoController;
use App\Http\Controllers\LoginController;
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
    return redirect()->route('contatos.index');
});

Route::get('/contatos', [ContatoController::class, 'index'])->name('contatos.index');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    Route::resource('contatos', ContatoController::class)->except('index');
});

Route::post('login', [LoginController::class, 'auth'])->name('auth.login');
Route::get('login', [LoginController::class, 'create'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');

