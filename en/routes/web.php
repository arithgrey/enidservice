<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Valoracion\PageController;

Route::get('/valoraciones/{id_servicio}', [PageController::class, 'encuesta']);
Route::get('/valoraciones-listado', [PageController::class, 'listado'])->name('valoracion-listado');;
Route::get('/valoraciones/{valoracion:slug}', [PageController::class, 'valoracion'])->name('valoracion-detalle');


Route::resource('valoracion', 'Valoracion\ValoracionController');



Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
