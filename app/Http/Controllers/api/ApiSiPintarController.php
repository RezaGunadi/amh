<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MenuMakanan;
use App\Models\Favorite;
use App\Models\History;
use App\Models\UserSearch;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
class ApiSiPintarController extends Controller
{
    public function statistics(Request $req)
    {
        $reqData = $req->all();
        $remember_token = '';
        if (array_key_exists('mobile_token', $reqData)) {
            $remember_token = $reqData['mobile_token'];
        } else {
            $remember_token = $reqData['remember_token'];
        }
        $user = User::where('remember_token', $remember_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        $statistics = [
            'total_users' => User::where('role', '!=', 'admin')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_foods' => MenuMakanan::count(),
            'total_categories' => MenuMakanan::distinct('kategori')->count(),
            'total_favorites' => Favorite::count(),
            'total_history' => History::count(),
            'total_searches' => UserSearch::count(),
        ];
        return response()->json(array(
            'error' => false,
            'message' => "Statistics",
            'data' => $statistics,
            'status_code' => 200,
            'signature' => null
        ));
    }


    public function addHistory(Request $request): JsonResponse
    {
        try {
            $reqData = $request->all();
            $remember_token = '';
            if (array_key_exists('mobile_token', $reqData)) {
                $remember_token = $reqData['mobile_token'];
            } else {
                $remember_token = $reqData['remember_token'];
            }
            $user = User::where('remember_token', $remember_token)->first();
            $food = MenuMakanan::where('id', $reqData['food_id'])->first();
            $history = History::create([
                'user_id' => $user->id,
                'food_id' => $food->id,
                'food_name' => $food->nama_makanan,
                'image_url' => $food->foto,
                'activity_type' => $reqData['activity_type'] ?? 'consumed',
                'consumed_at' => now()
            ]);
            return response()->json([
                'success' => true,
                'message' => 'History added successfully',
                'data' => $history
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function addFavorite(Request $request): JsonResponse
    {
        try {
            $reqData = $request->all();
            $remember_token = '';
            if (array_key_exists('mobile_token', $reqData)) {
                $remember_token = $reqData['mobile_token'];
            } else {
                $remember_token = $reqData['remember_token'];
            }
            $user = User::where('remember_token', $remember_token)->first();
            $food = MenuMakanan::where('id', $reqData['food_id'])->first();
            
            // Cek apakah ada favorite yang aktif (tidak di-soft-delete)
            $checkFavorite = Favorite::where('user_id', $user->id)->where('food_id', $food->id)->first();
            
            if ($checkFavorite) {
                // Jika ada favorite yang aktif, soft delete
                $checkFavorite->delete();
                return response()->json([
                    'error' => false,
                    'message' => 'Favorite removed successfully',
                    'data' => null,
                    'status_code' => 200,
                    'signature' => null
                ], 200);
            } else {
                // Cek apakah ada favorite yang sudah di-soft-delete
                $deletedFavorite = Favorite::withTrashed()
                    ->where('user_id', $user->id)
                    ->where('food_id', $food->id)
                    ->first();
                    History::create([
                        'user_id' => $user->id,
                        'food_id' => $food->id,
                        'food_name' => $food->nama_makanan,
                        'image_url' => $food->foto,
                        'activity_type' => 'favorite',
                        'consumed_at' => now()
                    ]);
                
                if ($deletedFavorite && $deletedFavorite->trashed()) {
                    // Jika ada yang sudah di-soft-delete, restore
                    $deletedFavorite->restore();
                    return response()->json([
                        'error' => false,
                        'message' => 'Favorite restored successfully',
                        'data' => $deletedFavorite,
                        'status_code' => 200,
                        'signature' => null
                    ], 200);
                } else {
                    // Jika tidak ada sama sekali, buat baru
                    $favorite = Favorite::create([
                        'user_id' => $user->id,
                        'food_id' => $food->id,
                        'food_name' => $food->nama_makanan,
                        'image_url' => $food->foto,
                    ]);
                    return response()->json([
                        'error' => false,
                        'message' => 'Favorite added successfully',
                        'data' => $favorite,
                        'status_code' => 200,
                        'signature' => null
                    ], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to add favorite',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ], 500);
        }
    }

    public function getHistory(Request $request): JsonResponse
    {
        try {
            $reqData = $request->all();
            $remember_token = '';
            if (array_key_exists('mobile_token', $reqData)) {
                $remember_token = $reqData['mobile_token'];
            } else {
                $remember_token = $reqData['remember_token'];
            }
            $user = User::where('remember_token', $remember_token)->first();
            $history = History::where('user_id', $user->id)
            
            ->join('menu_makanan', 'history.food_id', '=', 'menu_makanan.id')
            ->select('menu_makanan.*', 'history.consumed_at', 'history.activity_type','history.created_at')
            ->orderBy('history.consumed_at', 'desc')
            ->get();
            return response()->json([
                'error' => false,
                'message' => 'History fetched successfully',
                'data' => $history,
                'status_code' => 200,
                'signature' => null
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to get history',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ], 500);
        }
    }

    public function getFavorite(Request $request): JsonResponse
    {
        try {
            $reqData = $request->all();
            $remember_token = '';
            if (array_key_exists('mobile_token', $reqData)) {
                $remember_token = $reqData['mobile_token'];
            } else {
                $remember_token = $reqData['remember_token'];
            }
            $user = User::where('remember_token', $remember_token)->first();
            $favorite = Favorite::where('user_id', $user->id)->pluck('food_id')->toArray();
            $foods = MenuMakanan::whereIn('id', $favorite)->get();
            foreach($foods as $item){
                $item->is_favorite = true;
            }
            return response()->json([
                'error' => false,
                'message' => 'Favorite fetched successfully',
                'data' => $foods,
                'status_code' => 200,
                'signature' => null
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to get favorite',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ], 500);
        }
    }
    public function deleteHistory(Request $request): JsonResponse
    {
        Log::info($request->all());
        try {
            $reqData = $request->all();
            $remember_token = '';
            if (array_key_exists('mobile_token', $reqData)) {
                $remember_token = $reqData['mobile_token'];
            } else {
                $remember_token = $reqData['remember_token'];
            }
            
            // Verify user owns this history
            $user = User::where('remember_token', $remember_token)->first();
            if (!$user) {
                return response()->json([
                    'error' => true,
                    'message' => 'User not found',
                    'status_code' => 401,
                    'signature' => null
                ], 401);
            }
            if(array_key_exists('clear_all', $reqData)){
                $history = History::where('user_id', $user->id)->delete();
            } else {
                $history = History::where('id', $reqData['id'])
                            ->where('user_id', $user->id)
                            ->first();
            }
            if (!$history) {
                return response()->json([
                    'error' => true,
                    'message' => 'History not found',
                    'status_code' => 404,
                    'signature' => null
                ], 404);
            }
            
            // Soft delete the history
            $history->delete();
            
            return response()->json([
                'error' => false,
                'message' => 'History deleted successfully',
                'data' => null,
                'status_code' => 200,
                'signature' => null
            ], 200);
        }
        catch (\Exception $e) {
            Log::error('Failed to delete history: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => true,
                'message' => 'Failed to delete history',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ], 500);
        }
    }
    public function deleteMenuMakanan(Request $request): JsonResponse
    {
        Log::info($request->all());
        try {
            $reqData = $request->all();
            $menuMakanan = MenuMakanan::where('id', $reqData['id'])->first();
            if (!$menuMakanan) {
                return response()->json([
                    'error' => true,
                    'message' => 'Menu makanan not found',
                    'status_code' => 404,
                    'signature' => null
                ], 404);
            }
            $menuMakanan->delete();
            return response()->json([
                'error' => false,
                'message' => 'Menu makanan deleted successfully',
                'data' => null,
                'status_code' => 200,
                'signature' => null
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to delete menu makanan',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ], 500);
        }
    }

    public function addOrUpdateMenuMakanan(Request $request): JsonResponse
    {
        try {
            $reqData = $request->all();
            Log::info($reqData);
            // Handle image upload and compression
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $compressedImagePath = $this->compressAndSaveImage($image);
                Log::info($compressedImagePath);
                $reqData['foto'] = $compressedImagePath;
            }
            Log::info($reqData);
            $isEdit = false;
            if(array_key_exists('id', $reqData)){
                if ($reqData['id'] != null && $reqData['id'] != 0 && $reqData['id'] != '') {
                    $isEdit = true;
                }
            }
            if($isEdit){
                $menuMakanan = MenuMakanan::where('id', $reqData['id'])->first();
                $menuMakanan->update($reqData);
                return response()->json([
                    'error' => false,
                    'message' => 'Menu makanan updated successfully',
                    'data' => $menuMakanan,
                    'status_code' => 200,
                    'signature' => null
                ], 200);
            } else {
                $menuMakanan = MenuMakanan::create($reqData);
                return response()->json([
                    'error' => false,
                    'message' => 'Menu makanan added successfully',
                    'data' => $menuMakanan,
                    'status_code' => 200,
                    'signature' => null
                ], 200);
            }
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to add menu makanan',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ], 500);
        }
    }

    /**
     * Compress and save image to 100KB while maintaining original resolution
     */
    private function compressAndSaveImage($image, $targetSizeKB = 100)
    {
        $originalPath = $image->getPathname();
        $extension = $image->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $uploadPath = 'images/menu_makanan/';
        
        // Create directory if not exists
        if (!file_exists(public_path($uploadPath))) {
            mkdir(public_path($uploadPath), 0755, true);
        }
        
        $fullPath = public_path($uploadPath . $filename);
        
        // Get original image info
        $imageInfo = getimagesize($originalPath);
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // Create image resource based on type
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($originalPath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($originalPath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($originalPath);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($originalPath);
                break;
            default:
                throw new \Exception('Unsupported image type');
        }
        
        // Start with high quality and reduce until target size is reached
        $quality = 90;
        $targetSizeBytes = $targetSizeKB * 1024;
        
        do {
            // Save with current quality
            if ($mimeType === 'image/jpeg') {
                imagejpeg($sourceImage, $fullPath, $quality);
            } elseif ($mimeType === 'image/png') {
                // For PNG, we need to use a different approach
                $this->compressPng($sourceImage, $fullPath, $quality);
            } elseif ($mimeType === 'image/gif') {
                imagegif($sourceImage, $fullPath);
            } elseif ($mimeType === 'image/webp') {
                imagewebp($sourceImage, $fullPath, $quality);
            }
            
            $fileSize = filesize($fullPath);
            
            // If file is still too large, reduce quality
            if ($fileSize > $targetSizeBytes && $quality > 10) {
                $quality -= 10;
            } else {
                break;
            }
        } while ($fileSize > $targetSizeBytes && $quality > 10);
        
        // If still too large, try reducing dimensions while maintaining aspect ratio
        if (filesize($fullPath) > $targetSizeBytes) {
            $this->compressByResizing($sourceImage, $fullPath, $targetSizeBytes, $mimeType);
        }
        
        // Clean up
        imagedestroy($sourceImage);
        
        return $uploadPath . $filename;
    }
    
    /**
     * Compress PNG image
     */
    private function compressPng($sourceImage, $outputPath, $quality)
    {
        // Convert quality (0-100) to PNG compression level (0-9)
        $compression = 9 - round(($quality / 100) * 9);
        
        // Create a new image with the same dimensions
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);
        $newImage = imagecreatetruecolor($width, $height);
        
        // Preserve transparency
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        
        // Copy and resize
        imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $width, $height, $width, $height);
        
        // Save with compression
        imagepng($newImage, $outputPath, $compression);
        imagedestroy($newImage);
    }
    
    /**
     * Compress by resizing if quality compression is not enough
     */
    private function compressByResizing($sourceImage, $outputPath, $targetSizeBytes, $mimeType)
    {
        $originalWidth = imagesx($sourceImage);
        $originalHeight = imagesy($sourceImage);
        
        // Start with 90% of original size and reduce until target size is reached
        $scale = 0.9;
        $minScale = 0.1;
        
        do {
            $newWidth = round($originalWidth * $scale);
            $newHeight = round($originalHeight * $scale);
            
            // Create new image with reduced dimensions
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preserve transparency for PNG
            if ($mimeType === 'image/png') {
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);
            }
            
            // Resize
            imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
            
            // Save with high quality
            $quality = 85;
            if ($mimeType === 'image/jpeg') {
                imagejpeg($resizedImage, $outputPath, $quality);
            } elseif ($mimeType === 'image/png') {
                imagepng($resizedImage, $outputPath, 2);
            } elseif ($mimeType === 'image/gif') {
                imagegif($resizedImage, $outputPath);
            } elseif ($mimeType === 'image/webp') {
                imagewebp($resizedImage, $outputPath, $quality);
            }
            
            $fileSize = filesize($outputPath);
            
            // Clean up
            imagedestroy($resizedImage);
            
            // If still too large, reduce scale
            if ($fileSize > $targetSizeBytes && $scale > $minScale) {
                $scale -= 0.1;
            } else {
                break;
            }
        } while (filesize($outputPath) > $targetSizeBytes && $scale > $minScale);
    }
}