<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Controladores añadidos
use \App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ImpuestosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ValoracionesController;
use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\LineasController;
use App\Http\Controllers\CarritosController;
use App\Http\Controllers\PayPalController;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use App\Models\Impuesto;



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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Verificación email de registro
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

require __DIR__.'/auth.php';

// Catálogo
Route::get('/', [ProductosController::class, 'ver_catalogo'])->name('catalogo');
Route::get('/productos/{producto}', [ProductosController::class, 'ver_producto'])->name('productos.ver-producto');

// Modo usuario
Route::middleware('auth')->group(function () {
    Route::get('/direcciones', [DireccionesController::class, 'ver_mis_direcciones'])->name('direcciones.mis-direcciones');
    Route::get('/direcciones/create', [DireccionesController::class, 'create'])->name('direcciones.create');
    Route::post('/direcciones', [DireccionesController::class, 'store'])->name('direcciones.store');
    Route::get('/direcciones/{direccion}/edit', [DireccionesController::class, 'edit'])->name('direcciones.edit');
    Route::put('/direcciones/{direccion}/edit', [DireccionesController::class, 'update'])->name('direcciones.update');
    Route::delete('/direcciones/{direccion}', [DireccionesController::class, 'destroy'])->name('direcciones.destroy');

    // Carrito
    Route::get('/carrito', [CarritosController::class, 'ver_carrito'])->name('carritos.ver-carrito');
    Route::put('/carrito/edit', [CarritosController::class, 'actualizar_carrito'])->name('carritos.actualizar-carrito');
    Route::delete('/carrito', [CarritosController::class, 'borrar_item_carrito'])->name('carritos.borrar-item-carrito');

    Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
    Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
    Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
});


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
                'countImpuesto'=>Impuesto::count(),
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

    // Rutas Impuestos
    Route::get('/admin/impuestos', [ImpuestosController::class, 'index'])->name('admin.impuestos');
    Route::get('/admin/impuestos/create', [ImpuestosController::class, 'create'])->name('admin.impuestos.create');
    Route::post('/admin/impuestos', [ImpuestosController::class, 'store'])->name('admin.impuestos.store');
    Route::get('/admin/impuestos/{impuesto}/edit', [ImpuestosController::class, 'edit'])->name('admin.impuestos.edit');
    Route::put('/admin/impuestos/{impuesto}/edit', [ImpuestosController::class, 'update'])->name('admin.impuestos.update');
    Route::delete('/admin/impuestos/{impuesto}', [ImpuestosController::class, 'destroy'])->name('admin.impuestos.destroy');

    // Rutas Productos
    Route::get('/admin/productos', [ProductosController::class, 'index'])->name('admin.productos');
    Route::get('/admin/productos/create', [ProductosController::class, 'create'])->name('admin.productos.create');
    Route::post('/admin/productos', [ProductosController::class, 'store'])->name('admin.productos.store');
    Route::get('/admin/productos/{producto}/edit', [ProductosController::class, 'edit'])->name('admin.productos.edit');
    Route::put('/admin/productos/{producto}/edit', [ProductosController::class, 'update'])->name('admin.productos.update');
    Route::delete('/admin/productos/{producto}', [ProductosController::class, 'destroy'])->name('admin.productos.destroy');
    Route::get('/admin/productos/{producto}', [ProductosController::class, 'show'])->name('admin.productos.show');

    // Comentarios Productos
    Route::get('/admin/productos/{producto}/valoraciones', [ValoracionesController::class, 'ver_valoraciones'])->name('admin.valoraciones.ver-valoraciones');
    Route::get('/admin/valoraciones/{valoracion}/edit', [ValoracionesController::class, 'edit'])->name('admin.valoraciones.edit');
    Route::put('/admin/valoraciones/{valoracion}/edit', [ValoracionesController::class, 'update'])->name('admin.valoraciones.update');
    Route::delete('/admin/valoraciones/{valoracion}', [ValoracionesController::class, 'destroy'])->name('admin.valoraciones.destroy');

    // Rutas Usuario
    Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UsersController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}/edit', [UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UsersController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{user}', [UsersController::class, 'show'])->name('admin.users.show');

    // Rutas Direcciones
    Route::get('/admin/users/{user}/direcciones', [DireccionesController::class, 'ver_direcciones'])->name('admin.direcciones.ver-direcciones');

    // Rutas Facturas
    Route::get('/admin/users/{user}/facturas', [FacturasController::class, 'ver_facturas'])->name('admin.facturas.ver-facturas');

    // Rutas Lineas
    Route::get('/admin/facturas/{factura}/lineas', [LineasController::class, 'ver_lineas'])->name('admin.lineas.ver-lineas');

});
