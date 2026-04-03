<?php
use App\Http\Controllers\CuentaController;
use Illuminate\Support\Facades\Route;

// Rutas públicas para pruebas
Route::apiResource('cuentas', CuentaController::class);
Route::get('cuentas-resumen', [CuentaController::class, 'resumen']);

// Cuando se quiere proteger las rutas, utilizar:
//Route::middleware('auth:sanctum')->group(function () {
  //  Route::apiResource('cuentas', CuentaController::class);
  //  Route::get('cuentas-resumen', [CuentaController::class, 'resumen']);
//});


