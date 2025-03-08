<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KeycloakController;


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

// Route::post('/products', [ProductController::class, 'store']);
// Route::get('/products', [ProductController::class, 'index']);
// Route::get('/products/{id}', [ProductController::class, 'show']);
// Route::put('/products/{id}',  [ProductController::class, 'update']);
// Route::delete('/products/{id}',  [ProductController::class, 'destroy']);


// public endpoints
Route::get('/hello', function () {
    return ':)';
});

Route::post('/getToken', [KeycloakController::class, 'index']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::controller(ProductController::class)->group(function () {
        Route::post('/products', 'store');
        Route::get('/products', 'index');
        Route::get('/products/{id}', 'show');
        Route::put('/products/{id}',  'update');
        Route::delete('/products/{id}',  'destroy');
    });
});
