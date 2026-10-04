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


use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BankSampahController as SuperAdminBankSampahController;


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

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/local-reset-password', [AuthController::class, 'showLocalResetForm'])
        ->name('password.local-reset.form');

    Route::post('/local-reset-password', [AuthController::class, 'resetLocalPassword'])
        ->name('password.local-reset.update');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');

});


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'bank-sampah-admin.access'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Admin Bank Sampah Routes
    |--------------------------------------------------------------------------
    |
    | Khusus untuk role admin_bank_sampah.
    |
    */

    Route::middleware('bank-sampah-admin')
        ->prefix('admin/bank-sampah')
        ->name('admin.bank-sampah.')
        ->group(function () {

            /*
            | Dashboard Admin Bank Sampah
            */
            Route::get('/', [
                AdminBankSampahController::class,
                'index'
            ])->name('dashboard');


            /*
            | Update Bank Sampah milik Admin
            */
            Route::put('/', [
                AdminBankSampahController::class,
                'update'
            ])->name('update');


            /*
            | Katalog Marketplace
            */
            Route::get('/katalog', [
                AdminMarketplaceController::class,
                'index'
            ])->name('catalog.index');

            Route::post('/katalog', [
                AdminMarketplaceController::class,
                'store'
            ])->name('catalog.store');

            Route::put('/katalog/{product}', [
                AdminMarketplaceController::class,
                'update'
            ])->name('catalog.update');

            Route::delete('/katalog/{product}', [
                AdminMarketplaceController::class,
                'destroy'
            ])->name('catalog.destroy');


            /*
            | QRIS
            */
            Route::post('/qris', [
                AdminMarketplaceController::class,
                'updateQris'
            ])->name('qris.update');


            /*
            | Pesanan
            */
            Route::get('/pesanan', [
                AdminMarketplaceController::class,
                'orders'
            ])->name('orders');

            Route::patch(
                '/pesanan/{order}/konfirmasi-pembayaran',
                [
                    AdminMarketplaceController::class,
                    'confirmPayment'
                ]
            )->name('orders.confirm-payment');

        });


    /*
    |--------------------------------------------------------------------------
    | Super Admin Routes
    |--------------------------------------------------------------------------
    |
    | Khusus untuk role super_admin.
    |
    */

    Route::middleware('super-admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Dashboard Super Admin
            |--------------------------------------------------------------------------
            */

            Route::get('/', [
                AdminDashboardController::class,
                'index'
            ])->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | Manajemen Akun
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'users',
                AdminUserController::class
            )->except([
                        'show'
                    ]);


            /*
            |--------------------------------------------------------------------------
            | Manajemen Bank Sampah
            |--------------------------------------------------------------------------
            |
            | URL:
            | /admin/manage-bank-sampah
            |
            | Nama route:
            | admin.manage-bank-sampah.*
            |
            */

            Route::resource(
                'manage-bank-sampah',
                SuperAdminBankSampahController::class
            )
                ->except([
                    'show'
                ])
                ->parameters([
                    'manage-bank-sampah' => 'bank_sampah',
                ])
                ->names('manage-bank-sampah');

        });


    /*
    |--------------------------------------------------------------------------
    | Dashboard User
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Scanner
    |--------------------------------------------------------------------------
    */

    Route::post('/scanner/upload', [
        ScannerController::class,
        'store'
    ])->name('scanner.upload');

    Route::get('/scanner', [
        ScannerController::class,
        'index'
    ])->name('scanner');

    Route::get('/scanner/history', [
        ScannerController::class,
        'history'
    ])->name('scanner.history');


    /*
    |--------------------------------------------------------------------------
    | Education
    |--------------------------------------------------------------------------
    */

    Route::get('/education', [
        EducationController::class,
        'index'
    ])->name('education');

    Route::get('/education/{slug}', [
        EducationController::class,
        'show'
    ])->name('education.show');


    /*
    |--------------------------------------------------------------------------
    | Chatbot
    |--------------------------------------------------------------------------
    */

    Route::get('/chatbot', [
        ChatbotController::class,
        'index'
    ])->name('chatbot');


    /*
    |--------------------------------------------------------------------------
    | Bank Sampah untuk User
    |--------------------------------------------------------------------------
    */

    Route::get('/bank-sampah', [
        BankSampahController::class,
        'index'
    ])->name('bank-sampah');


    /*
    |--------------------------------------------------------------------------
    | Marketplace
    |--------------------------------------------------------------------------
    */


    Route::get('/marketplace', [MarketplaceController::class, 'index'])
        ->name('marketplace');
    Route::get('/marketplace/pesanan-saya', [MarketplaceController::class, 'orders'])
        ->name('marketplace.orders');
    Route::get('/marketplace/produk/{product}', [MarketplaceController::class, 'show'])
        ->name('marketplace.product');
    Route::post('/marketplace/produk/{product}/beli', [MarketplaceController::class, 'buy'])
        ->name('marketplace.product.buy');
    Route::get('/marketplace/pesanan/{order}/pembayaran', [MarketplaceController::class, 'payment'])
        ->name('marketplace.payment');
    Route::post('/marketplace/pesanan/{order}/pembayaran', [MarketplaceController::class, 'uploadPaymentProof'])
        ->name('marketplace.payment.upload');

    Route::get('/marketplace', [
        MarketplaceController::class,
        'index'
    ])->name('marketplace');

    Route::get(
        '/marketplace/produk/{product}',
        [
            MarketplaceController::class,
            'show'
        ]
    )->name('marketplace.product');

    Route::post(
        '/marketplace/produk/{product}/beli',
        [
            MarketplaceController::class,
            'buy'
        ]
    )->name('marketplace.product.buy');

    Route::get(
        '/marketplace/pesanan/{order}/pembayaran',
        [
            MarketplaceController::class,
            'payment'
        ]
    )->name('marketplace.payment');

    Route::post(
        '/marketplace/pesanan/{order}/pembayaran',
        [
            MarketplaceController::class,
            'uploadPaymentProof'
        ]
    )->name('marketplace.payment.upload');



    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    */

    Route::view(
        '/analytics',
        'dashboard.analytics'
    )->name('analytics');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'index'
    ])->name('profile');

});