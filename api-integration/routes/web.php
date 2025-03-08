<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/test-cache-redis', function() {
//     Cache::store('redis')->put('Laradock', 'Awesome', 100);
//     return response(['cache' => 'ok']);
// });
// Route::get('test-job', function() {
//     \App\Jobs\IntegrationJob::dispatch(['mail' => 'mdiazr2000@gmail.com']);
// });

Route::get('/', function () {
    return view('welcome');
});
