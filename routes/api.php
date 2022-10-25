<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get("/products", function () {
    return DB::table("products")->get();
});

Route::post('/user', [UserController::class, 'store']);
Route::get('/user', [UserController::class, 'get']);
Route::get('/user/{id}', [UserController::class, 'getById']);
Route::put('/user/{id}', [UserController::class, 'updateById']);
Route::delete('/user/{id}', [UserController::class, 'deleteById']);

Route::get('/product', [ProductController::class, 'get']);

Route::get('/category', [CategoryController::class, 'get']);
