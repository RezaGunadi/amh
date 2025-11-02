<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Password Reset Routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset-password');

Route::get('/', function () {
    return view('amhriset.welcome', [
        'title' => 'amhriset.com - Riset & Produk',
    ]);
});
// API Routes
Route::get('/tnc-child-care', function () {
    return view('tnc.child_care', [
        'title' => 'T&C Child Care',
    ]);
});
Route::get('/tnc-kelas-privat', function () {
    return view('tnc.kelas_privat', [
        'title' => 'T&C Kelas Privat',
    ]);
});
// Delete Account Routes
Route::get('/delete-account', [App\Http\Controllers\DeleteAccountController::class, 'index'])->name('delete-account');
Route::post('/delete-account/verify', [App\Http\Controllers\DeleteAccountController::class, 'verify'])->name('delete-account.verify');
Route::post('/delete-account', [App\Http\Controllers\DeleteAccountController::class, 'delete'])->name('delete-account.process');
Route::get('/delete-account/cancel', [App\Http\Controllers\DeleteAccountController::class, 'cancel'])->name('delete-account.cancel');

// Sipintar Web Routes
Route::get('/privacy-policy', function () {
    return view('sipintar.privacy_policy', [
        'title' => 'Privacy Policy - Sipintar',
    ]);
});

Route::get('/terms-conditions', function () {
    return view('sipintar.terms_conditions', [
        'title' => 'Terms & Conditions - Sipintar',
    ]);
});

Route::get('/sipintar', function () {
    return view('sipintar.welcome', [
        'title' => 'Sipintar - Edukasi Nutrisi',
    ]);
});

Route::get('/child-care', function () {
    return view('childcare.welcome', [
        'title' => 'Child Care - Smart Shoe Monitoring',
    ]);
});

// Auth::routes();