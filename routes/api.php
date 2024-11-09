<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\productoControlador;
use App\Http\Controllers\salidaControlador;
use App\Http\Controllers\entradaControlador;

//Productos
Route::get('/productos', [productoControlador::class, 'index']);
Route::get('/productos/{id}', function () {return 'Holi Productos';});
Route::post('/productos', [productoControlador::class, 'store']);
Route::put('/productos/{id}', [productoControlador::class, 'update']);
Route::patch('/productos/{id}', [productoControlador::class, 'updatePartial']);
Route::delete('/productos/{id}', [productoControlador::class, 'destroy']);


//Salidaaaas
Route::get('/salida', [salidaControlador::class, 'index']);
Route::post('/salida', [salidaControlador::class, 'store']);
Route::delete('/salida/{id}', [salidaControlador::class, 'destroy']);
Route::put('/salida/{id}', [salidaControlador::class, 'update']);


//Entradas
Route::get('/entrada', [entradaControlador::class, 'index']);
Route::post('/entrada', [entradaControlador::class, 'store']);
Route::delete('/entrada/{id}', [entradaControlador::class, 'destroy']);
Route::put('/entrada/{id}', [entradaControlador::class, 'update']);




