<?php

use Illuminate\Http\Request;



use Api\V1\ValoracionController as ValoracionV1;
use Api\V2\ValoracionController as ValoracionV2;

use Api\V1\BancoController;
use Api\V1\OrdenComentarioController;
use Api\V1\ProyectoPersonaFormaPagoController;
use Api\V1\UsuarioController;

Route::apiResource('v1/valoracion', ValoracionV1::class)->only(['show', 'index','destroy']);
Route::apiResource('v2/valoracion', ValoracionV2::class)->only(['show', 'index'])->middleware('auth:sanctum');

Route::apiResource('v1/banco', BancoController::class);
Route::apiResource('v1/orden-comentario', OrdenComentarioController::class);
Route::apiResource('v1/ppfp', ProyectoPersonaFormaPagoController::class);
//Route::apiResource('v1/usuario', UsuarioController::class);

Route::get('v1/usuario/ppfp',
	[
		App\Http\Controllers\Api\V1\UsuarioController::class,
        'ppfp'
	]);


Route::post('login',
	[
		App\Http\Controllers\Api\LoginController::class ,
		'login'
	]);
