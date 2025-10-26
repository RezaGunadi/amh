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
    return response()->json([
        'error' => false,
        'message' => "Welcome to Sipintar API",
        'data' => null,
        'status_code' => 200,
        'signature' => null
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
Route::get('/delete-account', function () {
    return view('delete_account', [
        'title' => 'Delete Account',
    ]);
});

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

// Auth::routes();