<?php

use Illuminate\Http\Request;



use Api\V1\ValoracionController as ValoracionV1;
use Api\V2\ValoracionController as ValoracionV2;

Route::apiResource('v1/valoracion', ValoracionV1::class)
		->only(['show', 'index','destroy']);

Route::apiResource('v2/valoracion', ValoracionV2::class)
		->only(['show', 'index'])->middleware('auth:sanctum');



Route::post('login', 
	[
		App\Http\Controllers\Api\LoginController::class ,
		'login'
	]);