<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConseilsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// Catalogue routes
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/catalogue', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/recherche', [CatalogController::class, 'search'])->name('catalog.search');
Route::get('/produit/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');

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

// Password Reset routes
Route::get('/mot-de-passe-oublie', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/mot-de-passe-oublie', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

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
    
    // Dashboard routes
    Route::get('/mes-achats', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Order routes
    Route::prefix('commandes')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}/confirmation', [OrderController::class, 'confirmation'])->name('confirmation');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });
});

// Contact routes (public)
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Conseils routes (public)
Route::get('/conseils', [ConseilsController::class, 'index'])->name('conseils.index');
Route::get('/conseils/{guide}', [ConseilsController::class, 'guide'])->name('conseils.guide');

// Route temporaire pour se connecter automatiquement en admin
Route::get('/auto-login-admin', function () {
    $admin = App\Models\User::where('email', 'admin@woodshop.fr')->first();
    if ($admin) {
        auth()->login($admin);
        return redirect('/admin')->with('success', 'Connecté automatiquement en tant qu\'admin !');
    }
    return redirect('/connexion')->with('error', 'Utilisateur admin non trouvé');
})->name('auto.admin.login');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    // Dashboard admin
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des produits
    Route::resource('products', AdminProductController::class);
});

