<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Controladores añadidos
use \App\Http\Controllers\CategoriasController;
use \App\Http\Controllers\ProductosController;

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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Modo admin
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Rutas Categoria
    Route::resource('categorias', CategoriasController::class);

    // Rutas Productos
    Route::resource('productos', ProductosController::class);

});
