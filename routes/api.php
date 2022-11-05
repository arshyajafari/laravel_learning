<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
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

Route::group([
    'middleware' => [
        'auth:admin'
    ],
    // 'prefix' => 'test'
], function (){
    Route::post('/user', [UserController::class, 'store']);
    Route::get('/user', [UserController::class, 'get']);
    Route::get('/user/{id}', [UserController::class, 'getById']);
    Route::put('/user/{id}', [UserController::class, 'updateById']);
    Route::delete('/user/{id}', [UserController::class, 'deleteById']);
});

Route::get('/product', [ProductController::class, 'get']);
Route::get('/product/{id}', [ProductController::class, 'getById']);

Route::get('/category', [CategoryController::class, 'get']);

Route::post('/admin/login', [AdminController::class, 'login']);


Route::get('/test', function (){
    /*
    for ($i = 0; $i < 10; $i++)
    {
        $category = \App\Models\CategoryModel::create([
            'title' => fake()->title,
            'description' => fake()->text
        ]);

        for ($j = 0; $j < 10; $j++)
        {
            \App\Models\ProductModel::create([
                "title" => fake()->title,
                "description" => fake()->text,
                "price" => rand(1000, 1000000),
                "image" => fake()->image,
                "category_id" => $category->id
            ]);
        }
    }
    */

    foreach (\App\Models\ProductModel::all() AS $product)
    {
        DB::table('category_product')->insert([
            'category_id' => $product->category_id,
            'product_id' => $product->id,
        ]);
    }
});
