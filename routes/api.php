<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json([
        'error' => false,
        'message' => "Welcome to Sipintar API",
        'data' => null,
        'status_code' => 200,
        'signature' => null
    ]);
});
// API Routes untuk Child Care App (tanpa CSRF protection)
Route::post('/login', [App\Http\Controllers\api\ApiAuth::class, 'apiLogin']);
Route::post('/logout', [App\Http\Controllers\api\ApiAuth::class, 'apiLogout']);
Route::post('/regist', [App\Http\Controllers\api\ApiAuth::class, 'apiRegist']);
Route::get('/check-username', [App\Http\Controllers\api\ApiAuth::class, 'checkUsername']);
Route::post('/auth/update', [App\Http\Controllers\api\ApiAuth::class, 'apiUpdate']);
Route::post('/auth/change-password', [App\Http\Controllers\api\ApiAuth::class, 'apiChangePassword']);
Route::post('/auth/reset-password', [App\Http\Controllers\api\ApiAuth::class, 'resetPassword']);
Route::post('/auth/update-password', [App\Http\Controllers\api\ApiAuth::class, 'updatePassword']);
Route::post('/help', [App\Http\Controllers\api\ApiArduinoController::class, 'helpRequest']);
Route::get('/admin/users', [App\Http\Controllers\api\ApiAuth::class, 'adminUser']);
Route::post('/admin', [App\Http\Controllers\api\ApiAuth::class, 'createOrUpdateAdmin']);
Route::delete('/admin', [App\Http\Controllers\api\ApiAuth::class, 'deleteAdmin']);
Route::get('/admin', [App\Http\Controllers\api\ApiAuth::class, 'getAdmin']);

Route::post('/arduino/dht-pulse/{token}', [App\Http\Controllers\api\ApiArduinoController::class, 'dhtPulse']);
Route::get('/arduino/get-dht-pulse/detail/{token}', [App\Http\Controllers\api\ApiArduinoController::class, 'dhtPulseGetDetail']);
Route::get('/arduino/get-dht-pulse/{user_id}', [App\Http\Controllers\api\ApiArduinoController::class, 'dhtPulseGet']);
Route::post('/arduino/device/input/{user_id}', [App\Http\Controllers\api\ApiArduinoController::class, 'regisDevice']);
Route::post('/arduino/device/delete/{user_id}', [App\Http\Controllers\api\ApiArduinoController::class, 'deleteDevice']);
Route::get('/get-version', [App\Http\Controllers\api\ApiAuth::class, 'mobileVersion']);
Route::get('/profile', [App\Http\Controllers\api\ApiAuth::class, 'profile']);
Route::delete('/profile', [App\Http\Controllers\api\ApiAuth::class, 'deleteProfile']);
Route::post('/change-profile-images', [App\Http\Controllers\api\ApiAuth::class, 'changeProfileImage']);


// Route untuk API Arduino Atiqah
Route::post('/arduino/atiqah/{token}', [\App\Http\Controllers\api\ApiArduinoController::class, 'atiqahData']);


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::match(['get', 'post'], '/api/get-help', [App\Http\Controllers\api\NewsController::class, 'helpRequest'])->name('api_get_help');
// API routes moved to api.php to avoid CSRF issues
// Route::match(['get', 'post'], '/api/help', [App\Http\Controllers\api\ApiArduinoController::class, 'helpRequest'])->name('api_help');
// Route::match(['get', 'post'], '/api/login', [App\Http\Controllers\api\ApiAuth::class, 'apiLogin'])->name('api_login');
// Route::match(['get', 'post'], '/api/regist', [App\Http\Controllers\api\ApiAuth::class, 'apiRegist'])->name('api_regist');
// Route::match(['get', 'post'], '/api/auth/update', [App\Http\Controllers\api\ApiAuth::class, 'apiUpdate'])->name('api_auth_update');
// Route::match(['get', 'post'], '/api/auth/change-password', [App\Http\Controllers\api\ApiAuth::class, 'apiChangePassword'])->name('api_auth_change_password');
Route::match(['get', 'post'], '/arduino/get-dht-pulse/detail/and-remove/{token}', [App\Http\Controllers\api\ApiArduinoController::class, 'dhtPulseGetDetailAndRemove'])->name('api_dht_pulse_detail_and_remove');

Route::match(['get', 'post'], '/apiget-version', [App\Http\Controllers\api\ApiAuth::class, 'mobileVersion'])->name('mobileVersion');
Route::match(['get', 'post'], '/apiprofile', [App\Http\Controllers\api\ApiAuth::class, 'profile'])->name('profile');


Route::post('/change-profile-images', [App\Http\Controllers\api\ApiAuth::class, 'changeProfileImage'])->name('changeProfileImage');

// Sipintar API Routes
// Guest routes (no authentication required)
Route::prefix('sipintar')->group(function () {
    Route::get('/statistics', [App\Http\Controllers\api\ApiSiPintarController::class, 'statistics']);


    Route::post('/food', [App\Http\Controllers\api\ApiSiPintarController::class, 'addOrUpdateMenuMakanan']);
    Route::get('/food', [App\Http\Controllers\api\GuestController::class, 'getMenuMakanan']);
    Route::delete('/food', [App\Http\Controllers\api\ApiSiPintarController::class, 'deleteMenuMakanan']);
    Route::get('/food/{id}', [App\Http\Controllers\api\GuestController::class, 'getMenuMakananById']);

    Route::get('/history', [App\Http\Controllers\api\ApiSiPintarController::class, 'getHistory']);
    Route::get('/favorite', [App\Http\Controllers\api\ApiSiPintarController::class, 'getFavorite']);
    Route::post('/history', [App\Http\Controllers\api\ApiSiPintarController::class, 'addHistory']);
    Route::delete('/history', [App\Http\Controllers\api\ApiSiPintarController::class, 'deleteHistory']);
    Route::post('/favorite', [App\Http\Controllers\api\ApiSiPintarController::class, 'addFavorite']);
    Route::get('/categories', [App\Http\Controllers\api\GuestController::class, 'getCategories']);
    Route::get('/search', [App\Http\Controllers\api\GuestController::class, 'searchMenuMakanan']);
    Route::get('/app-info', [App\Http\Controllers\api\GuestController::class, 'getAppInfo']);
});

// App information routes (no authentication required)
Route::prefix('sipintar/app')->group(function () {
    Route::get('/info', [App\Http\Controllers\api\AppInfoController::class, 'getAppInfo']);
    Route::get('/version', [App\Http\Controllers\api\AppInfoController::class, 'getVersionInfo']);
    Route::get('/config', [App\Http\Controllers\api\AppInfoController::class, 'getAppConfig']);
    Route::get('/store-info', [App\Http\Controllers\api\AppInfoController::class, 'getStoreInfo']);
});

// Authenticated routes
Route::prefix('sipintar')->middleware('auth:sanctum')->group(function () {
    // Account management
    Route::prefix('account')->group(function () {
        Route::post('/delete', [App\Http\Controllers\api\AccountController::class, 'deleteAccount']);
        Route::post('/request-deletion', [App\Http\Controllers\api\AccountController::class, 'requestAccountDeletion']);
        Route::get('/deletion-status', [App\Http\Controllers\api\AccountController::class, 'getDeletionRequestStatus']);
        Route::post('/cancel-deletion', [App\Http\Controllers\api\AccountController::class, 'cancelDeletionRequest']);
        Route::get('/export-data', [App\Http\Controllers\api\AccountController::class, 'exportUserData']);
    });
    
    // Consent management
    Route::prefix('consent')->group(function () {
        Route::get('/info', [App\Http\Controllers\api\ConsentController::class, 'getConsentInfo']);
        Route::get('/status', [App\Http\Controllers\api\ConsentController::class, 'getConsentStatus']);
        Route::post('/update', [App\Http\Controllers\api\ConsentController::class, 'updateConsent']);
        Route::post('/accept-terms', [App\Http\Controllers\api\ConsentController::class, 'acceptTermsAndPrivacy']);
        Route::post('/withdraw', [App\Http\Controllers\api\ConsentController::class, 'withdrawConsent']);
    });
});
