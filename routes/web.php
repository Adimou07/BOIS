<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\AuthController;

// Catalogue routes
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/catalogue', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/recherche', [CatalogController::class, 'search'])->name('catalog.search');
Route::get('/produit/{product}', [CatalogController::class, 'show'])->name('catalog.show');

// Cart routes
Route::prefix('panier')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{cartItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Delivery routes
Route::prefix('livraison')->name('delivery.')->group(function () {
    Route::post('/calculate', [DeliveryController::class, 'calculate'])->name('calculate');
    Route::get('/zones', [DeliveryController::class, 'zones'])->name('zones');
});

// Authentication routes
Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

// Email verification routes with code
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verify-code', [AuthController::class, 'verifyCode'])
    ->middleware('auth')->name('verification.verify-code');

Route::post('/email/resend-code', [AuthController::class, 'resendCode'])
    ->middleware(['auth', 'throttle:3,1'])->name('verification.resend-code');

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profile.update');
});
