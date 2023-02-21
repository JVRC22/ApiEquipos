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
    Route::post('/login', [UsersController::class, 'login'])->name('login')->middleware('status_correo');
    Route::post('/logout', [UsersController::class, 'logout'])->name('logout')->middleware('auth:sanctum')->middleware('rol: 1,2,3')->middleware('status');

    #Autenticación
    Route::prefix('/auth')->group(function (){
        Route::get('/enviarCodigo', [AuthController::class, 'enviarCodigo'])->name('auth.enviarCodigo');
        Route::post('/verificarCodigo', [AuthController::class, 'verificarCodigo'])->name('auth.verificarCodigo');
    });

    #Funciones de administrador
    Route::prefix('/admin')->middleware('auth:sanctum')->group(function (){
        Route::get('/', [UsersController::class, 'mostrarUsuarios'])->name('admin.mostrarUsuarios')->middleware('rol: 1')->middleware('status');
        Route::put('/rol/{id}', [UsersController::class, 'cambiarRol'])->name('admin.cambiarRol')->middleware('rol: 1')->middleware('status');
        Route::put('/status/{id}', [UsersController::class, 'cambiarStatus'])->name('admin.cambiarStatus')->middleware('rol: 1')->middleware('status');
        Route::delete('/{id}', [UsersController::class, 'eliminarUsuario'])->name('admin.eliminarUsuario')->middleware('rol: 1')->middleware('status');
    });

    #Funciones de usuario y administrador
    Route::prefix('/user')->middleware('auth:sanctum')->group(function (){
        Route::get('/{id}', [UsersController::class, 'mostrarUsuarioUnico'])->name('user.mostrarUsuarioUnico')->middleware('rol: 1,2,3')->middleware('status');
        Route::put('/{id}', [UsersController::class, 'cambiarNombre'])->name('user.cambiarNombre')->middleware('rol: 1,2,3')->middleware('status');
        Route::put('/{id}', [UsersController::class, 'cambiarPassword'])->name('user.cambiarPassword')->middleware('rol: 1,2,3')->middleware('status');
    });
});

#Partidos
Route::prefix('/partidos')->middleware('auth:sanctum')->group(function (){
    Route::get('/', [PartidosController::class, 'mostrar'])->name('partidos.mostrar')->middleware('rol: 1,2,3')->middleware('status');
    Route::post('/', [PartidosController::class, 'agregar'])->name('partidos.agregar')->middleware('rol: 1,2,3')->middleware('status');

    Route::put('/{id}', [PartidosController::class, 'editar'])->name('partidos.editar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::delete('/{id}', [PartidosController::class, 'eliminar'])->name('partidos.eliminar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::get('/{id}', [PartidosController::class, 'mostrarUnico'])->name('partidos.mostrarUnico')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
});

#Jugadores
Route::prefix('/jugadores')->middleware('auth:sanctum')->group(function (){
    Route::get('/', [JugadoresController::class, 'mostrar'])->name('jugadores.mostrar')->middleware('rol: 1,2,3')->middleware('status');
    Route::post('/', [JugadoresController::class, 'agregar'])->name('jugadores.agregar')->middleware('rol: 1,2,3')->middleware('status');

    Route::put('/{id}', [JugadoresController::class, 'editar'])->name('jugadores.editar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::delete('/{id}', [JugadoresController::class, 'eliminar'])->name('jugadores.eliminar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::get('/{id}', [JugadoresController::class, 'mostrarUnico'])->name('jugadores.mostrarUnico')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
});

#Equipos
Route::prefix('/equipos')->middleware('auth:sanctum')->group(function (){
    Route::get('/', [EquiposController::class, 'mostrar'])->name('equipos.mostrar')->middleware('rol: 1,2,3')->middleware('status');
    Route::post('/', [EquiposController::class, 'agregar'])->name('equipos.agregar')->middleware('rol: 1,2,3')->middleware('status');
    Route::get('/equipo/{id}', [EquiposController::class, 'mostrarJugadoresCiertoEquipos'])->name('equipos.mostrarJugadoresCiertoEquipos')->where('id', '[0-9]+')->middleware('rol: 1,2,3')->middleware('status');

    Route::put('/{id}', [EquiposController::class, 'editar'])->name('equipos.editar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::delete('/{id}', [EquiposController::class, 'eliminar'])->name('equipos.eliminar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::get('/{id}', [EquiposController::class, 'mostrarUnico'])->name('equipos.mostrarUnico')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::put('/jugadores/{id}', [EquiposController::class, 'cambiarEquipoJugadores'])->name('equipos.cambiarEquipoJugadores')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
});

#Estados
Route::prefix('/estados')->middleware('auth:sanctum')->group(function (){
    Route::get('/', [EstadosController::class, 'mostrar'])->name('estados.mostrar')->middleware('rol: 1,2,3')->middleware('status');
    Route::post('/', [EstadosController::class, 'agregar'])->name('estados.agregar')->middleware('rol: 1,2,3')->middleware('status');

    Route::put('/{id}', [EstadosController::class, 'editar'])->name('estados.editar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::delete('/{id}', [EstadosController::class, 'eliminar'])->name('estados.eliminar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::get('/{id}', [EstadosController::class, 'mostrarUnico'])->name('estados.mostrarUnico')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
});

#Propietarios
Route::prefix('/propietarios')->middleware('auth:sanctum')->group(function (){
    Route::get('/', [PropietariosController::class, 'mostrar'])->name('propietarios.mostrar')->middleware('rol: 1,2,3')->middleware('status');
    Route::post('/', [PropietariosController::class, 'agregar'])->name('propietarios.agregar')->middleware('rol: 1,2,3')->middleware('status');
    
    Route::put('/{id}', [PropietariosController::class, 'editar'])->name('propietarios.editar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::delete('/{id}', [PropietariosController::class, 'eliminar'])->name('propietarios.eliminar')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
    Route::get('/{id}', [PropietariosController::class, 'mostrarUnico'])->name('propietarios.mostrarUnico')->where('id', '[0-9]+')->middleware('rol: 1,2')->middleware('status');
});