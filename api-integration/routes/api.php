<?php

use App\Http\Controllers\ShopifyProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


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

//Route::group(['middleware' => 'auth:api'], function () {
Route::controller(ShopifyProductController::class)->group(function () {
    Route::post('/products', 'store');
    Route::get('/products', 'index');
    Route::get('/products/{id}', 'show');
    Route::put('/products/{id}', 'update');
    Route::delete('/products/{id}', 'destroy');
});
//});


Route::get('/shopify/products', function () {
    $products = Http::shopify()->get('/products.json');
    return response($products);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


