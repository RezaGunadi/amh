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

Route::post('/generate-monthly-paket', function () {
    try {
        // Verify API key if needed
        if (request()->header('X-API-Key') !== config('app.api_key')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the seeder instance
        $seeder = new \Database\Seeders\PaketSoalSeeder();
        
        // Get current year
        $currentYear = date('Y');
        
        // Mata pelajaran per jenjang
        $mataPelajaran = [
            'SD' => [
                'Matematika',
                'Bahasa Indonesia',
                'IPA',
                'IPS',
                'Bahasa Inggris',
                'PKn'
            ],
            'SMP' => [
                'Matematika',
                'Bahasa Indonesia',
                'Bahasa Inggris',
                'IPA',
                'IPS',
                'PKn',
                'Seni Budaya',
                'PJOK'
            ],
            'SMA' => [
                'Matematika',
                'Bahasa Indonesia',
                'Bahasa Inggris',
                'Fisika',
                'Kimia',
                'Biologi',
                'Sejarah',
                'Geografi',
                'Ekonomi',
                'Sosiologi'
            ]
        ];

        $generatedPackages = [];

        // Generate one package for each subject
        foreach ($mataPelajaran as $jenjang => $mapelList) {
            foreach ($mapelList as $mapel) {
                // Create new package
                $paketSoal = \App\Models\PaketSoal::create([
                    'user_id' => 1, // Admin ID
                    'name' => "Paket Bulanan {$mapel} {$jenjang} " . date('F Y'),
                    'jenjang' => $jenjang,
                    'mapel' => $mapel,
                    'tahun' => $currentYear,
                    'is_public' => 1,
                    'is_deleted' => 0
                ]);

                // Generate 50 questions for the package
                for ($j = 1; $j <= 50; $j++) {
                    $seeder->generateSoal($paketSoal->id, $mapel, $jenjang);
                }

                $generatedPackages[] = [
                    'id' => $paketSoal->id,
                    'name' => $paketSoal->name,
                    'jenjang' => $jenjang,
                    'mapel' => $mapel
                ];
            }
        }

        return response()->json([
            'message' => 'Monthly packages generated successfully',
            'packages' => $generatedPackages
        ]);

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Error generating monthly packages: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->middleware('api');

// Route untuk API Arduino Atiqah
Route::post('/arduino/atiqah/{token}', [\App\Http\Controllers\api\ApiArduinoController::class, 'atiqahData']);
