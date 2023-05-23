<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Controladores añadidos
use \App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsersController;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;

//use \App\Http\Controllers\ProductosController;

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
    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return view(
            'admin.dashboard',
            [
                'countCategoria'=>Categoria::count(),
                'countProducto'=>Producto::count(),
                'countUser'=>User::count(),
            ]
        );
    })->name('admin.dashboard');

    // Rutas Categoria
    Route::get('/admin/categorias', [CategoriasController::class, 'index'])->name('admin.categorias');
    Route::get('/admin/categorias/create', [CategoriasController::class, 'create'])->name('admin.categorias.create');
    Route::post('/admin/categorias', [CategoriasController::class, 'store'])->name('admin.categorias.store');
    Route::get('/admin/categorias/{categoria}/edit', [CategoriasController::class, 'edit'])->name('admin.categorias.edit');
    Route::put('/admin/categorias/{categoria}/edit', [CategoriasController::class, 'update'])->name('admin.categorias.update');
    Route::delete('/admin/categorias/{categoria}', [CategoriasController::class, 'destroy'])->name('admin.categorias.destroy');

    // Rutas Productos
    Route::get('/admin/productos', [ProductosController::class, 'index'])->name('admin.productos');
    Route::get('/admin/productos/create', [ProductosController::class, 'create'])->name('admin.productos.create');
    Route::post('/admin/productos', [ProductosController::class, 'store'])->name('admin.productos.store');
    Route::get('/admin/productos/{producto}/edit', [ProductosController::class, 'edit'])->name('admin.productos.edit');
    Route::put('/admin/productos/{producto}/edit', [ProductosController::class, 'update'])->name('admin.productos.update');
    Route::delete('/admin/productos/{producto}', [ProductosController::class, 'destroy'])->name('admin.productos.destroy');
    Route::get('/admin/productos/{producto}', [ProductosController::class, 'show'])->name('admin.productos.show');

    // Rutas Usuario
    Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UsersController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}/edit', [UsersController::class, 'update'])->name('admin.users.update');


});
