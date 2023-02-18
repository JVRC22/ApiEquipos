<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\EstadosController;
use App\Http\Controllers\JugadoresController;
use App\Http\Controllers\PartidosController;
use App\Http\Controllers\PropietariosController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

#Usuarios
Route::prefix('')->group(function (){
    Route::post('/register', [UsersController::class, 'register'])->name('register');
    Route::post('/login', [UsersController::class, 'login'])->name('login');
    Route::post('/logout', [UsersController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

    #Autenticación
    Route::prefix('/auth')->group(function (){
        Route::get('/enviarCodigo', [AuthController::class, 'enviarCodigo'])->name('auth.enviarCodigo');
        Route::post('/verificarCodigo', [AuthController::class, 'verificarCodigo'])->name('auth.verificarCodigo');
    });

    #Funciones de administrador
    Route::prefix('/admin')->group(function (){
        Route::get('/', [UsersController::class, 'mostrarUsuarios'])->name('admin.mostrarUsuarios');
        Route::delete('/{id}', [UsersController::class, 'eliminarUsuario'])->name('admin.eliminarUsuario');
        Route::put('/{id}', [UsersController::class, 'cambiarRol'])->name('admin.cambiarRol');
        Route::put('/status/{id}', [UsersController::class, 'cambiarStatus'])->name('admin.cambiarStatus');
    });

    #Funciones de usuario y administrador
    Route::prefix('/user')->group(function (){
        Route::get('/{id}', [UsersController::class, 'mostrarUsuarioUnico'])->name('user.mostrarUsuarioUnico');
        Route::put('/{id}', [UsersController::class, 'cambiarNombre'])->name('user.cambiarNombre');
        Route::put('/{id}', [UsersController::class, 'cambiarPassword'])->name('user.cambiarPassword');
    });
});


#Partidos
Route::prefix('/partidos')->group(function (){
    Route::post('/', [PartidosController::class, 'agregar'])->name('partidos.agregar');
    Route::put('/{id}', [PartidosController::class, 'editar'])->name('partidos.editar')->where('id', '[0-9]+');
    Route::delete('/{id}', [PartidosController::class, 'eliminar'])->name('partidos.eliminar')->where('id', '[0-9]+');
    Route::get('/', [PartidosController::class, 'mostrar'])->name('partidos.mostrar');
    Route::get('/{id}', [PartidosController::class, 'mostrarUnico'])->name('partidos.mostrarUnico')->where('id', '[0-9]+');
});

#Jugadores
Route::prefix('/jugadores')->group(function (){
    Route::post('/', [JugadoresController::class, 'agregar'])->name('jugadores.agregar');
    Route::put('/{id}', [JugadoresController::class, 'editar'])->name('jugadores.editar')->where('id', '[0-9]+');
    Route::delete('/{id}', [JugadoresController::class, 'eliminar'])->name('jugadores.eliminar')->where('id', '[0-9]+');
    Route::get('/', [JugadoresController::class, 'mostrar'])->name('jugadores.mostrar');
    Route::get('/{id}', [JugadoresController::class, 'mostrarUnico'])->name('jugadores.mostrarUnico')->where('id', '[0-9]+');
});

#Equipos
Route::prefix('/equipos')->group(function (){
    Route::post('/', [EquiposController::class, 'agregar'])->name('equipos.agregar');
    Route::put('/{id}', [EquiposController::class, 'editar'])->name('equipos.editar')->where('id', '[0-9]+');
    Route::delete('/{id}', [EquiposController::class, 'eliminar'])->name('equipos.eliminar')->where('id', '[0-9]+');
    Route::get('/', [EquiposController::class, 'mostrar'])->name('equipos.mostrar');
    Route::get('/{id}', [EquiposController::class, 'mostrarUnico'])->name('equipos.mostrarUnico')->where('id', '[0-9]+');
});

#Estados
Route::prefix('/estados')->group(function (){
    Route::post('/', [EstadosController::class, 'agregar'])->name('estados.agregar');
    Route::put('/{id}', [EstadosController::class, 'editar'])->name('estados.editar')->where('id', '[0-9]+');
    Route::delete('/{id}', [EstadosController::class, 'eliminar'])->name('estados.eliminar')->where('id', '[0-9]+');
    Route::get('/', [EstadosController::class, 'mostrar'])->name('estados.mostrar');
    Route::get('/{id}', [EstadosController::class, 'mostrarUnico'])->name('estados.mostrarUnico')->where('id', '[0-9]+');
});

#Propietarios
Route::prefix('/propietarios')->group(function (){
    Route::post('/', [PropietariosController::class, 'agregar'])->name('propietarios.agregar');
    Route::put('/{id}', [PropietariosController::class, 'editar'])->name('propietarios.editar')->where('id', '[0-9]+');
    Route::delete('/{id}', [PropietariosController::class, 'eliminar'])->name('propietarios.eliminar')->where('id', '[0-9]+');
    Route::get('/', [PropietariosController::class, 'mostrar'])->name('propietarios.mostrar');
    Route::get('/{id}', [PropietariosController::class, 'mostrarUnico'])->name('propietarios.mostrarUnico')->where('id', '[0-9]+');
});