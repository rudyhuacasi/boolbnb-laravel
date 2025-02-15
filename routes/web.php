<?php

use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GeoAutoSearchController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\VisualController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// use App\Http\Controllers\Admin\SuggestionController;

use App\Http\Controllers\Admin\GeocodingController;
use App\Http\Controllers\Admin\PaymentController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth', 'verified')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        //? Recources HOME:
        Route::resource('homes', HomeController::class)
            //* chiamo la rotta con lo slug e non con l'id:
            ->parameters(['homes' => 'home:slug']);

        //? Recources SERVICE:
        Route::resource('services', ServiceController::class);

        //? Recources AD:
        Route::resource('ads', AdController::class);

        //? Recources USER:
        Route::resource('users', RegisteredUserController::class);

        Route::get('visual', [VisualController::class, 'index'])->name('visual.index');
    });


//? rotta per chiamata API tomtom:
Route::get('/get-coordinates', [GeocodingController::class, 'getCoordinates'])
    ->name('get.coordinates');

//? rotta per il suggeritore degli indirizzi chiamata API tomtom:
Route::get('/get-address-suggestions', [GeoAutoSearchController::class, 'getAddressSuggestions'])
    ->name('get.address.suggestions');

//? rotta per i pagamenti:
Route::get('/payment/form/{slug}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment/form/{slug}', [PaymentController::class, 'storeAds'])->name('payment.store');


Route::get('/braintree/token', [PaymentController::class, 'generateToken'])->name('braintree.token');
Route::post('/braintree/process', [PaymentController::class, 'processPayment'])->name('braintree.process');

//? User:
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
