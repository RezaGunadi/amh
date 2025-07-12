<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('page_news');
Route::get('/news/{id}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat');
Route::get('/chat/new', [App\Http\Controllers\ChatController::class, 'create'])->name('addChat');
Route::post('/chat/store', [App\Http\Controllers\ChatController::class, 'store'])->name('chat_store');

Route::get('/komen/detail/{id?}', [App\Http\Controllers\KomenController::class, 'index'])->name('komen');
Route::get('/pinned/{chat_id?}/{id?}/{user_id?}', [App\Http\Controllers\KomenController::class, 'pinned'])->name('pinned');
Route::post('/komen/store', [App\Http\Controllers\KomenController::class, 'store'])->name('komen_store');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('my_profile');
Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('update_my_profile');
Route::post('/profile/{id?}', [App\Http\Controllers\ProfileController::class, 'store'])->name('profile_edit');

Route::get('/test', [App\Http\Controllers\SoalController::class, 'index'])->name('test');
Route::get('/test', [App\Http\Controllers\SoalController::class, 'index'])->name('practice');

Route::post('/jawaban', [App\Http\Controllers\SoalController::class, 'showHasil'])->name('jawaban');
Route::post('/soal', [App\Http\Controllers\SoalController::class, 'show'])->name('goto_soal');
Route::get('/soal/create/{paket_id}', [App\Http\Controllers\SoalController::class, 'create'])->name('create_soal');
Route::post('/soal/store', [App\Http\Controllers\SoalController::class, 'store'])->name('store_soal');
Route::match(['get', 'post'], '/soal/delete/{soal_id}', [App\Http\Controllers\SoalController::class, 'delete'])->name('delete_soal');

Route::get('/soal/list', [App\Http\Controllers\SoalController::class, 'list'])->name('list_paket');
Route::get('/paket/create', [App\Http\Controllers\PaketSoalController::class, 'createPaket'])->name('create_paket');
Route::match(['get', 'post'], '/paket/delete/{paket_id}', [App\Http\Controllers\PaketSoalController::class, 'delete'])->name('delete_paket');
Route::match(['get', 'post'], '/paket/change/public/{paket_id}', [App\Http\Controllers\PaketSoalController::class, 'changePublic'])->name('change_public_paket');
Route::match(['get', 'post'], '/paket/edit/{paket_id}', [App\Http\Controllers\PaketSoalController::class, 'edit'])->name('edit_paket');
Route::match(['get', 'post'], '/paket/store', [App\Http\Controllers\PaketSoalController::class, 'store'])->name('store_paket');

Route::get('/news/create', [App\Http\Controllers\HomeController::class, 'create'])->name('create_news');
Route::post('/news/store', [App\Http\Controllers\HomeController::class, 'store'])->name('news_store');


Route::get('/materi', [App\Http\Controllers\MateriController::class, 'index'])->name('materi');
Route::get('/materi/show/{slug}', [App\Http\Controllers\MateriController::class, 'show'])->name('show_materi');
Route::get('/materi/create', [App\Http\Controllers\MateriController::class, 'create'])->name('create_materi');
Route::post('/materi/store', [App\Http\Controllers\MateriController::class, 'store'])->name('store_materi');

Route::match(['get', 'post'], '/materi/image-upload', [App\Http\Controllers\MateriController::class, 'uploadImage'])->name('upload_image_materi');
// Route::post('/soal', [App\Http\Controllers\SoalController::class, 'show'])->name('goto_soal');


Route::get('/about-us', function () {
    return view('home.about', [
        'title' => 'About Kelas Privat',
    ]);
});
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
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::match(['get', 'post'], '/api/get-help', [App\Http\Controllers\api\NewsController::class, 'helpRequest'])->name('api_get_help');
Route::match(['get', 'post'], '/api/help', [App\Http\Controllers\api\ApiArduinoController::class, 'helpRequest'])->name('api_help');
Route::match(['get', 'post'], '/api/login', [App\Http\Controllers\api\ApiAuth::class, 'apiLogin'])->name('api_login');
Route::match(['get', 'post'], '/api/regist', [App\Http\Controllers\api\ApiAuth::class, 'apiRegist'])->name('api_regist');
Route::match(['get', 'post'], '/api/auth/update', [App\Http\Controllers\api\ApiAuth::class, 'apiUpdate'])->name('api_auth_update');
Route::match(['get', 'post'], '/api/auth/change-password', [App\Http\Controllers\api\ApiAuth::class, 'apiChangePassword'])->name('api_auth_change_password');
Route::match(['get', 'post'], '/api/arduino/dht-pulse/{token}', [App\Http\Controllers\api\ApiArduinoController::class, 'dhtPulse'])->name('api_dht_pulse');
Route::match(['get', 'post'], '/api/arduino/get-dht-pulse/detail/{token}', [App\Http\Controllers\api\ApiArduinoController::class, 'dhtPulseGetDetail'])->name('api_dht_pulse_detail');
Route::match(['get', 'post'], '/api/arduino/get-dht-pulse/detail/and-remove/{token}', [App\Http\Controllers\api\ApiArduinoController::class, 'dhtPulseGetDetailAndRemove'])->name('api_dht_pulse_detail_and_remove');
Route::match(['get', 'post'], '/api/arduino/get-dht-pulse/{user_id}', [App\Http\Controllers\api\ApiArduinoController::class, 'dhtPulseGet'])->name('api_dht_pulse');
Route::match(['get', 'post'], '/api/arduino/device/input/{user_id}', [App\Http\Controllers\api\ApiArduinoController::class, 'regisDevice'])->name('regis_device');
Route::match(['get', 'post'], '/api/arduino/device/delete/{user_id}', [App\Http\Controllers\api\ApiArduinoController::class, 'deleteDevice'])->name('delete_device');


Route::match(['get', 'post'], '/api/get-version', [App\Http\Controllers\api\ApiAuth::class, 'mobileVersion'])->name('mobileVersion');
Route::match(['get', 'post'], '/api/profile', [App\Http\Controllers\api\ApiAuth::class, 'profile'])->name('profile');
Route::match(['get', 'post'], '/api/news/', [App\Http\Controllers\api\NewsController::class, 'news'])->name('news');
Route::match(['get', 'post'], '/api/test', [App\Http\Controllers\api\TestController::class, 'list'])->name('list');


Route::match(['get', 'post'], '/api/test-detail', [App\Http\Controllers\api\TestController::class, 'detail'])->name('detail');
Route::post('/api/test-answer', [App\Http\Controllers\api\TestController::class, 'answer'])->name('answer');
Route::post('/api/create-test-package', [App\Http\Controllers\api\TestController::class, 'createTestPackage'])->name('createTestPackage');
Route::post('/api/create-test-package-detail', [App\Http\Controllers\api\TestController::class, 'createTestPackageDetail'])->name('createTestPackageDetail');
Route::get('/api/get-test-answer', [App\Http\Controllers\api\TestController::class, 'getAnswer'])->name('getAnswer');
Route::get('/api/test-detail-history', [App\Http\Controllers\api\TestController::class, 'detailHistory'])->name('detailHistory');

Route::get('/api/get-leader-board', [App\Http\Controllers\api\LeaderBoardController::class, 'leaderBoard'])->name('leaderBoard');
Route::get('/api/test-share-soal', [App\Http\Controllers\api\TestController::class, 'shareSoal'])->name('shareSoal');
Route::get('/api/test-detail-by-token', [App\Http\Controllers\api\TestController::class, 'detailByToken'])->name('detailByToken');
Route::get('/api/hasil-test-siswa', [App\Http\Controllers\api\TestController::class, 'hasiltestSiswa'])->name('hasiltestSiswa');
Route::get('/api/hasil-test-siswa-package-list', [App\Http\Controllers\api\TestController::class, 'hasilTestSiswaPackageList'])->name('hasilTestSiswaPackageList');
Route::post('/api/delete-soal', [App\Http\Controllers\api\TestController::class, 'deletePackageDetail'])->name('deletePackageDetail');
Route::post('/api/delete-package', [App\Http\Controllers\api\TestController::class, 'deletePackage'])->name('deletePackage');

Route::get('/api/my-test', [App\Http\Controllers\api\TestController::class, 'myTest'])->name('myTest');



Route::post('/api/change-profile-images', [App\Http\Controllers\api\ApiAuth::class, 'changeProfileImage'])->name('changeProfileImage');


Route::post('/api/create-news', [App\Http\Controllers\api\NewsController::class, 'createNews'])->name('createNews');

// SEO-optimized pages
Route::get('/les-privat', function () {
    return view('pages.les-privat');
})->name('les-privat');

Route::get('/bank-soal', function () {
    return view('pages.bank-soal');
})->name('bank-soal');

Route::get('/soal', [App\Http\Controllers\SoalController::class, 'index'])->name('soal.index');
Route::get('/soal/{id}', [App\Http\Controllers\SoalController::class, 'show'])->name('soal.show');
Route::post('/soal/{id}/answer/{index}', [App\Http\Controllers\SoalController::class, 'showHasil'])->name('submit_answer');
Route::post('/soal/{id}/save-temp', [App\Http\Controllers\SoalController::class, 'saveTempAnswers'])->name('save_temp_answers');
Route::get('/soal/{id}/result', [App\Http\Controllers\SoalController::class, 'showResult'])->name('soal.result');

// Contact Route
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Privacy Policy Route
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Terms & Conditions Route
Route::get('/terms', function () {
    return view('terms');
})->name('terms');
