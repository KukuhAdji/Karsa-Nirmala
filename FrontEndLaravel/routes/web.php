<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BankSampahController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\AdminBankSampahController;
use App\Http\Controllers\AdminMarketplaceController;


/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');

});


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'bank-sampah-admin.access'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::middleware('bank-sampah-admin')
        ->prefix('admin/bank-sampah')
        ->name('admin.bank-sampah.')
        ->group(function () {
            Route::get('/', [AdminBankSampahController::class, 'index'])
                ->name('dashboard');
            Route::put('/', [AdminBankSampahController::class, 'update'])
                ->name('update');
            Route::get('/katalog', [AdminMarketplaceController::class, 'index'])
                ->name('catalog.index');
            Route::post('/katalog', [AdminMarketplaceController::class, 'store'])
                ->name('catalog.store');
            Route::put('/katalog/{product}', [AdminMarketplaceController::class, 'update'])
                ->name('catalog.update');
            Route::delete('/katalog/{product}', [AdminMarketplaceController::class, 'destroy'])
                ->name('catalog.destroy');
            Route::post('/qris', [AdminMarketplaceController::class, 'updateQris'])
                ->name('qris.update');
            Route::get('/pesanan', [AdminMarketplaceController::class, 'orders'])
                ->name('orders');
        });


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Scanner
    |--------------------------------------------------------------------------
    */

    Route::post('/scanner/upload', [ScannerController::class, 'store'])
        ->name('scanner.upload');

    Route::get('/scanner', [ScannerController::class, 'index'])
        ->name('scanner');

    Route::get('/scanner/history', [ScannerController::class, 'history'])
        ->name('scanner.history');


    /*
    |--------------------------------------------------------------------------
    | Education
    |--------------------------------------------------------------------------
    */

    Route::get('/education', [EducationController::class, 'index'])
        ->name('education');

    Route::get('/education/{slug}', [EducationController::class, 'show'])
        ->name('education.show');


    /*
    |--------------------------------------------------------------------------
    | Chatbot
    |--------------------------------------------------------------------------
    */

    Route::get('/chatbot', [ChatbotController::class, 'index'])
        ->name('chatbot');


    /*
    |--------------------------------------------------------------------------
    | Bank Sampah
    |--------------------------------------------------------------------------
    */

    Route::get('/bank-sampah', [BankSampahController::class, 'index'])
        ->name('bank-sampah');


    /*
    |--------------------------------------------------------------------------
    | Marketplace
    |--------------------------------------------------------------------------
    */

    Route::get('/marketplace', [MarketplaceController::class, 'index'])
        ->name('marketplace');
    Route::get('/marketplace/produk/{product}', [MarketplaceController::class, 'show'])
        ->name('marketplace.product');
    Route::post('/marketplace/produk/{product}/beli', [MarketplaceController::class, 'buy'])
        ->name('marketplace.product.buy');
    Route::get('/marketplace/pesanan/{order}/pembayaran', [MarketplaceController::class, 'payment'])
        ->name('marketplace.payment');
    Route::post('/marketplace/pesanan/{order}/pembayaran', [MarketplaceController::class, 'uploadPaymentProof'])
        ->name('marketplace.payment.upload');


    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    */

    Route::view('/analytics', 'dashboard.analytics')
        ->name('analytics');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

});