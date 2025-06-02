<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

// Route::get('welcome', function () {
//     return view('welcome');
// })->name('welcome');

// Route::get('hola', function () {
//     return view('hola');
// });
// Ruta para la página principal
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/privacidad', function () {
    return view('info/privacidad');
})->name('privacidad');

Route::get('/sobreNosotros', function () {
    return view('info/sobreNosotros');
})->name('sobreNosotros');



Route::prefix('usuario')->name('usuario.')->group(function () {

    // Rutas para el registro
    Route::get('registro', [UsuarioController::class, 'registro'])->name('registro');
    Route::post('registro', [UsuarioController::class, 'save'])->name('save');

    // Rutas para el inicio de sesión
    Route::get('sesion', [UsuarioController::class, 'sesion'])->name('sesion');
    // Ruta POST para procesar el login
    Route::post('login', [UsuarioController::class, 'login'])->name('login');


    // Rutas para listado de usuarios (solo admins)
    Route::get('listado', [UsuarioController::class, 'listado'])->name('listado');

    // Rutas para editar y eliminar usuarios
    Route::get('editar/{id}', [UsuarioController::class, 'editar'])->name('editar');
    Route::post('update', [UsuarioController::class, 'update'])->name('update');
    Route::post('update2', [UsuarioController::class, 'update2'])->name('update2');
    Route::get('eliminar/{id}', [UsuarioController::class, 'eliminar'])->name('eliminar');

    Route::get('perfil', [UsuarioController::class, 'perfil'])->name('perfil');

    // Ruta para cerrar sesión
    Route::get('logout', [UsuarioController::class, 'logout'])->name('logout');

    // Route::get('cancelar/{token}', [UsuarioController::class, 'cancelarRegistro'])->name('cancelar');

    Route::get('confirmar/{token}', [UsuarioController::class, 'confirmar'])->name('confirmar');

});

Route::prefix('categoria')->name('categoria.')->group(function () {
    Route::get('index', [CategoriaController::class, 'index'])->name('index');
    Route::get('crear', [CategoriaController::class, 'crear'])->name('crear');
    Route::post('save', [CategoriaController::class, 'save'])->name('save');
    // Route::get('eliminar', [CategoriaController::class, 'eliminar'])->name('eliminar');
    Route::get('delete/{id}', [CategoriaController::class, 'delete'])->name('delete');
    Route::get('ver/{id}', [CategoriaController::class, 'ver'])->name('ver');
    Route::get('editar/{id}', [CategoriaController::class, 'editar'])->name('editar');
    Route::post('actualizar/{id}', [CategoriaController::class, 'update'])->name('update');

});

Route::prefix('producto')->name('producto.')->group(function () {
    // Productos destacados (inicio)
    Route::get('index', [ProductoController::class, 'index'])->name('index');

    // Ver un solo producto
    Route::get('ver/{id}', [ProductoController::class, 'ver'])->name('ver');

    // Gestión (requiere admin)
    Route::get('gestion', [ProductoController::class, 'gestion'])->name('gestion');

    // Crear producto
    Route::get('crear', [ProductoController::class, 'crear'])->name('crear');

    // Guardar producto (nuevo o editado)
    Route::post('save/{id?}', [ProductoController::class, 'save'])->name('save');

    // Editar producto
    Route::get('editar/{id}', [ProductoController::class, 'editar'])->name('editar');

    // Eliminar producto
    Route::get('eliminar/{id}', [ProductoController::class, 'eliminar'])->name('eliminar');

    Route::get('{id}/trailer', [ProductoController::class, 'verTrailer'])->name('trailer');
    
    Route::get('{id}/pelicula', [ProductoController::class, 'verPelicula'])->name('pelicula');

    Route::get('resultados', [ProductoController::class, 'resultados'])->name('resultados');

    Route::get('buscar', [ProductoController::class, 'buscar'])->name('buscar');
    
    Route::get('streaming/{id}', [ProductoController::class, 'stream'])->name('streaming');

    Route::get('streamingT/{id}', [ProductoController::class, 'streamTrailer'])->name('streamingT');

});


use App\Http\Controllers\CarritoController;

Route::prefix('carrito')->name('carrito.')->group(function () {
    Route::get('index', [CarritoController::class, 'index'])->name('index');
    Route::get('add/{id}', [CarritoController::class, 'add'])->name('add');
    Route::get('delete/{index}', [CarritoController::class, 'delete'])->name('delete');
    Route::get('deleteAll', [CarritoController::class, 'deleteAll'])->name('deleteAll');
});

Route::prefix('pedido')->name('pedido.')->group(function () {
Route::get('hacer', [PedidoController::class, 'hacer'])->name('hacer');
Route::post('add', [PedidoController::class, 'add'])->name('add');
Route::get('confirmado', [PedidoController::class, 'confirmado'])->name('confirmado');
Route::get('mis-pedidos', [PedidoController::class, 'misPedidos'])->name('mis_pedidos');
Route::get('detalle/{id}', [PedidoController::class, 'detalle'])->name('detalle');
Route::get('eliminar/{id}', [PedidoController::class, 'eliminar'])->name('eliminar');
Route::get('gestion', [PedidoController::class, 'gestion'])->name('gestion');
Route::post('estado', [PedidoController::class, 'estadoPedidos'])->name('estado');
Route::post('pagar', [PedidoController::class, 'pagar'])->name('pagar');
Route::get('realizado', [PedidoController::class, 'realizado'])->name('realizado');
Route::get('cancelar', [PedidoController::class, 'cancelar'])->name('cancelar');
Route::get('cancelado', [PedidoController::class, 'cancelado'])->name('cancelado');

});