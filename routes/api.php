<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\VisualController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//? rotta per i messaggi: 
Route::post('/homes/{slug}/message', [HomeController::class, 'storeMessage']);

//? rotta per l'autocomplete -> suggeritore:
Route::get('homes/autocomplete', [SearchController::class, 'autocomplete']);

//? rotta search:
Route::get('homes/search', [SearchController::class, 'search']);

Route::get('/homes/sponsorship', [HomeController::class, 'sponsorship']);

//? rotta risorsa homes:
Route::apiResource('homes', HomeController::class);

Route::get('services', [ServiceController::class, 'index']);

Route::post('visuals', [VisualController::class, 'store']);

