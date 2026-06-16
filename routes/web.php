<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AudienciaController;
use App\Http\Controllers\DelitosController;
use App\Http\Controllers\ImputadosController;
use App\Http\Controllers\JuecesController;
use App\Http\Controllers\PsicologosController;
use App\Http\Controllers\ResumenController;
use App\Http\Controllers\TipoAudienciaController;
use App\Http\Controllers\TraductorController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('auth.showLogin');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.showRegister');
    Route::post('/register', [AuthController::class, 'store'])->name('auth.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Crear audiencias y administrar resumenes -> admin y oficinistas
Route::middleware(['auth', 'role:admin,oficinista'])->group(function () {
    Route::get('/audiencias/create', [AudienciaController::class, 'create'])->name('audiencias.create');
    Route::post('/audiencias', [AudienciaController::class, 'store'])->name('audiencias.store');
    Route::post(
        '/delitos/ajax',
        [DelitosController::class, 'storeAjax']
    )->name('delitos.ajax.store');
    Route::post(
        '/imputados/ajax',
        [ImputadosController::class, 'storeAjax']
    )->name('imputados.ajax.store');
    Route::get('/resumen/create', [ResumenController::class, 'create'])->name('resumen.create');
    Route::post('/resumen', [ResumenController::class, 'store'])->name('resumen.store');
    Route::get('/resumen/{resumen}/edit', [ResumenController::class, 'edit'])->name('resumen.edit');
    Route::put('/resumen/{resumen}', [ResumenController::class, 'update'])->name('resumen.update');
    Route::delete('/resumen/{resumen}', [ResumenController::class, 'destroy'])->name('resumen.destroy');
});

// Administracion de audiencias -> solo admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/audiencias/{audiencia}/edit', [AudienciaController::class, 'edit'])->name('audiencias.edit');
    Route::put('/audiencias/{audiencia}', [AudienciaController::class, 'update'])->name('audiencias.update');
    Route::patch('/audiencias/{audiencia}/diferir', [AudienciaController::class, 'diferir'])->name('audiencias.diferir');
});

// Catalogos -> solo admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('delitos', DelitosController::class);
    // Route::post('/delitos/ajax', [DelitosController::class, 'storeAjax'])
    //     ->name('delitos.ajax.store');
    Route::resource('tipoaudiencias', TipoAudienciaController::class);
    Route::resource('jueces', JuecesController::class)->parameters([
        'jueces' => 'juez',
    ]);
    Route::resource('psicologos', PsicologosController::class);
    Route::resource('traductores', TraductorController::class)->parameters([
        'traductores' => 'traductor',
    ]);

    Route::get('admin/delitos', [DelitosController::class, 'index'])->name('admin.delitos');
    Route::get('admin/jueces', [JuecesController::class, 'index'])->name('admin.jueces');
    Route::get('admin/tipoaudiencias', [TipoAudienciaController::class, 'index'])->name('admin.tipoaudiencias');
    Route::get('admin/psicologos', [PsicologosController::class, 'index'])->name('admin.psicologos');
    Route::get('admin/traductores', [TraductorController::class, 'index'])->name('admin.traductores');
    Route::get('admin/imputados', [ImputadosController::class, 'index'])->name('admin.imputados');
});

// Imputados: admin administra; capturista_imputados solo consulta y agrega.
Route::middleware(['auth', 'role:admin,capturista_imputados'])->group(function () {
    Route::get('/imputados', [ImputadosController::class, 'index'])->name('imputados.index');
    Route::get('/imputados/create', [ImputadosController::class, 'create'])->name('imputados.create');
    Route::post('/imputados', [ImputadosController::class, 'store'])->name('imputados.store');
    Route::get('/imputados/{imputado}', [ImputadosController::class, 'show'])->name('imputados.show');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/imputados/{imputado}/edit', [ImputadosController::class, 'edit'])->name('imputados.edit');
    Route::put('/imputados/{imputado}', [ImputadosController::class, 'update'])->name('imputados.update');
    Route::patch('/imputados/{imputado}', [ImputadosController::class, 'update']);
    Route::delete('/imputados/{imputado}', [ImputadosController::class, 'destroy'])->name('imputados.destroy');
});

// Consultas -> admin, oficinista, secretario y capturista de imputados
Route::middleware(['auth', 'role:admin,oficinista,secretario,capturista_imputados'])->group(function () {
    Route::get('/audiencias/reporte/exportar', [AudienciaController::class, 'exportReport'])->name('audiencias.report.export');
    Route::get('/audiencias/reporte/imprimir', [AudienciaController::class, 'printReport'])->name('audiencias.report.print');
    Route::get('/audiencias/reporte', [AudienciaController::class, 'report'])->name('audiencias.report');
    Route::get('/audiencias', [AudienciaController::class, 'index'])->name('audiencias.index');
    Route::get('/resumen', [ResumenController::class, 'index'])->name('resumen.index');
    Route::get('/resumen/{resumen}', [ResumenController::class, 'show'])->name('resumen.show');
});

// Rutas solo para administradores
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/usuarios', function () {
        return 'Administrar usuarios';
    })->name('admin.usuarios');
    Route::get('/admin/roles', function () {
        return 'Administrar roles';
    })->name('admin.roles');
});
