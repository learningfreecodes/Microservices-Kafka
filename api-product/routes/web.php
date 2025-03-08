<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocsController;
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

// Route::domain('/*')->group(function () {
//    return ':){account}';
// });
// https://hubii_keycloak.local/
// // Route::middleware(['keycloak', 'auth'])->group(function () {
// //     Route::get('/docs/{path?}','')->where('path', '.*');
// });
// https://product.ubii.local/localtelescope/telescope-ap

// dd(config()->all());
Route::get('/', function () {
   return view('welcome');
});


// Route::get('login/keycloak', 'LoginController@redirectToKeycloak')->name('login.keycloak');
// Route::get('login/keycloak/callback', 'LoginController@handleKeycloakCallback');


// Route::get('docs/api', function () {
   
// });
