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

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register');

});


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


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