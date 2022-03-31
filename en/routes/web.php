<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Valoracion\PageController;



Route::get('/valoraciones/{id}', [PageController::class, 'encuesta'])
    ->where('id', '[0-9]+');

Route::resource('valoracion', 'Valoracion\ValoracionController');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::resource('solicitud-retiro', 'SolicitudRetiro\SolicitudRetiroController');

Route::resource('lista-negra', 'ListaNegra\ListaNegraController');


Route::resource('banco', 'Banco\BancoController')
    ->middleware('auth');

Route::resource('cuenta-banco', 'CuentaBanco\CuentaBancoController')->middleware('auth');
