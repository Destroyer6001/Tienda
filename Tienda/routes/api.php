<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CompraController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/categorias',[CategoriaController::class, 'show']);
Route::get('/categoria/{id}',[CategoriaController::class, 'showById']);
Route::post('/categoria/store',[CategoriaController::class, 'store']);
Route::put('/categoria/{id}', [CategoriaController::class, 'update']);
Route::delete('/categoria/{id}',[CategoriaController::class, 'destroy']);
Route::get('/marcas',[MarcaController::class, 'show']);
Route::get('/marca/{id}',[MarcaController::class, 'showById']);
Route::post('/marca/store',[MarcaController::class, 'store']);
Route::put('/marca/{id}', [MarcaController::class, 'update']);
Route::delete('/marca/{id}',[MarcaController::class, 'destroy']);
Route::get('/productos',[ProductoController::class, 'show']);
Route::get('/producto/{id}',[ProductoController::class, 'showById']);
Route::post('/producto/store',[ProductoController::class, 'store']);
Route::put('/producto/{id}', [ProductoController::class, 'update']);
Route::delete('/producto/{id}',[ProductoController::class, 'destroy']);
Route::get('/categorias/productos/{id}',[CategoriaController::class, 'productosPorCategoria']);
Route::get('/marcas/productos/{id}',[MarcaController::class,'productosPorMarca']);
Route::post('/compras/store',[CompraController::class,'store']);
Route::get('/compras',[CompraController::class,'index']);
Route::get('/compras/{id}',[CompraController::class,'show']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
