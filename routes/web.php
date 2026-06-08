<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AudienciaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Autenticación
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('auth.showLogin');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.showRegister');
    Route::post('/register', [AuthController::class, 'store'])->name('auth.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Ejemplos de rutas protegidas por rol
// Crear/editar audiencias y resúmenes -> solo admin y oficinistas
Route::middleware(['auth', 'role:admin,oficinista'])->group(function () {
    Route::get('/audiencias/create', [AudienciaController::class, 'create'])->name('audiencias.create');
    Route::post('/audiencias', [AudienciaController::class, 'store'])->name('audiencias.store');

    Route::get('/resumen/create', function () { return 'Formulario crear resumen'; })->name('resumen.create');
    Route::post('/resumen', function () { return 'Guardar resumen'; })->name('resumen.store');
});

// Ver listados -> admin, oficinista y secretario
Route::middleware(['auth', 'role:admin,oficinista,secretario'])->group(function () {
    Route::get('/audiencias', [AudienciaController::class, 'index'])->name('audiencias.index');
    Route::get('/resumen', function () { return 'Listado de resúmenes'; })->name('resumen.index');
});

// Rutas solo para administradores
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/jueces', function () { return 'Administrar jueces'; })->name('admin.jueces');
    Route::get('/admin/tipo-audiencia', function () { return 'Administrar tipos de audiencia'; })->name('admin.tipo_audiencia');
    Route::get('/admin/delitos', function () { return 'Administrar delitos'; })->name('admin.delitos');
    Route::get('/admin/psicologos', function () { return 'Administrar psicólogos'; })->name('admin.psicologos');
    Route::get('/admin/traductores', function () { return 'Administrar traductores'; })->name('admin.traductores');
    Route::get('/admin/usuarios', function () { return 'Administrar usuarios'; })->name('admin.usuarios');
    Route::get('/admin/roles', function () { return 'Administrar roles'; })->name('admin.roles');
});
