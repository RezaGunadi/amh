<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuMakanan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\History;
use App\Models\Favorite;
use App\Models\UserSearch;

class GuestController extends Controller
{
    /**
     * Get all menu makanan for guest users
     */
    public function getMenuMakanan(Request $request): JsonResponse
    {
        try {
            $skip = $request->get('skip', 0);
            $limit = $request->get('limit', 50);
            $category = $request->get('category');
            $search = $request->get('search');
            $allRequest = $request->all();
            $data = $request->all();
            $favoriteIds = [];
            $isAdmin = false;

            if (array_key_exists('remember_token', $allRequest)) {
                $user = User::where('remember_token', $allRequest['remember_token'])->first();
                if($user){
                    if($user->role == 'admin'||$user->role == 'superadmin'||$user->role == 'super_admin'){
             $isAdmin = true;  
                }
                }
            }
            $allData =MenuMakanan::query();

            $query = MenuMakanan::query();

            if(!$isAdmin){
                $allData = MenuMakanan::where('is_active', true);
                $query = MenuMakanan::where('is_active', true);
            }
            if(array_key_exists('remember_token', $data)){
                $user = User::where('remember_token', $data['remember_token'])->first();
                $favorite = Favorite::where('user_id', $user->id)->get();
                $favoriteIds = $favorite->pluck('food_id')->toArray();
            }

            if ($category) {
                $category = strtolower($category);
                if ($category != 'all'&&$category != ''&&$category != null&&$category != 'semua') {
                    $query->where('kategori', 'like', "%{$category}%");
                    $allData = $allData->where('kategori', 'like', "%{$category}%");
                }
            }

            if ($search) {
                if ($search != '' && $search != null && $search != 'all' && $search != 'semua') {
                    $query->where('nama_makanan', 'like', "%{$search}%");
                    if (array_key_exists('remember_token', $allRequest)) {
                        $user = User::where('remember_token', $allRequest['remember_token'])->first();
                        if($user){
                        UserSearch::create([
                                'user_id' => $user->id,
                                'search_query' => $search,
                            ]);
                        }
                    }
                }
            }
            if (array_key_exists('health_index', $data)) {
                $healthIndex = $data['health_index'];
                if ($healthIndex !== '' && $healthIndex !== null && $healthIndex !== 'all' && $healthIndex !== 'semua') {
                    $query->where(function($q) use ($healthIndex) {
                        // We'll sum only numeric columns for scoring. Adjust weights as appropriate.
                        $fields = [
                            'protein_persen',
                            'lemak_persen',
                            'gula_persen',
                            'garam_persen',
                            'serat_persen',
                            'zat_besi_persen',
                            'kalsium_persen'
                        ];

                        $rawSum = implode(' + ', $fields);

                        if ($healthIndex === 'lebih sehat') {
                            $q->whereRaw("($rawSum) > ?", [50]);
                        } else if ($healthIndex === 'cukup sehat') {
                            $q->whereRaw("($rawSum) > ? AND ($rawSum) <= ?", [40, 50]);
                        } else if ($healthIndex === 'butuh perbaikan') {
                            $q->whereRaw("($rawSum) > ? AND ($rawSum) <= ?", [30, 40]);
                        } else if ($healthIndex === 'tidak sehat') {
                            $q->whereRaw("($rawSum) <= ?", [30]);
                        }
                    });
                    $allData = $allData->where(function($q) use ($healthIndex) {
                        // We'll sum only numeric columns for scoring. Adjust weights as appropriate.
                        $fields = [
                            'protein_persen',
                            'lemak_persen',
                            'gula_persen',
                            'garam_persen',
                            'serat_persen',
                            'zat_besi_persen',
                            'kalsium_persen'
                        ];
                        $rawSum = implode(' + ', $fields);
                        if ($healthIndex === 'lebih sehat') {
                            $q->whereRaw("($rawSum) > ?", [50]);
                        } else if ($healthIndex === 'cukup sehat') {
                            $q->whereRaw("($rawSum) >= ? AND ($rawSum) < ?", [40, 50]);
                        } else if ($healthIndex === 'butuh perbaikan') {
                            $q->whereRaw("($rawSum) >= ? AND ($rawSum) < ?", [30, 40]);
                        } else if ($healthIndex === 'tidak sehat') {
                            $q->whereRaw("($rawSum) < ?", [30]);
                        }
                    });
                }
            }
            $query= $query->skip($skip)->take($limit);

            $menuMakanan = $query->get();
            $allDataCount = $allData->count();
            foreach($menuMakanan as $item){
                if (array_key_exists('remember_token', $data)) {
                    if(in_array($item->id, $favoriteIds)){
                        $item->is_favorite = true;
                    }
                }
                $item->all_data_count = $allDataCount;
                
            }
            

            return response()->json([
                'error' => false,
                'message' => 'Menu makanan retrieved successfully',
                'data' => $menuMakanan,
                'status_code' => 200,
                'signature' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve menu makanan',
                'error' => $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ], 500);
        }
    }

    /**
     * Get menu makanan by ID for guest users
     */
    public function getMenuMakananById(string $id): JsonResponse
    {
        try {
            $menuMakanan = MenuMakanan::where('id', $id)
                ->where('is_active', true)
                ->first();

            if (!$menuMakanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu makanan not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Menu makanan retrieved successfully',
                'data' => $menuMakanan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve menu makanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get categories for guest users
     */
    public function getCategories(): JsonResponse
    {
        try {
            $categories = MenuMakanan::where('is_active', true)
                ->distinct()
                ->pluck('kategori')
                ->filter()
                ->values();

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search menu makanan for guest users
     */
    public function searchMenuMakanan(Request $request): JsonResponse
    {
        try {
            $search = $request->get('q');
            $perPage = $request->get('per_page', 20);

            if (!$search) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search query is required'
                ], 400);
            }

            $menuMakanan = MenuMakanan::where('is_active', true)
                ->where(function ($query) use ($search) {
                    $query->where('nama_makanan', 'like', "%{$search}%")
                        ->orWhere('deskripsi_menu', 'like', "%{$search}%")
                        ->orWhere('komposisi', 'like', "%{$search}%");
                })
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Search results retrieved successfully',
                'data' => $menuMakanan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search menu makanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get app information for guest users
     */
    public function getAppInfo(): JsonResponse
    {
        try {
            $appInfo = [
                'name' => 'Sipintar',
                'version' => '1.0.0',
                'description' => 'Aplikasi edukasi nutrisi dan tracking konsumsi makanan',
                'features' => [
                    'Browse menu makanan',
                    'View nutritional information',
                    'Search and filter content',
                    'Educational content about nutrition'
                ],
                'requires_login' => [
                    'Add to favorites',
                    'Track consumption history',
                    'Personalized recommendations',
                    'Save preferences'
                ],
                'privacy_policy_url' => url('/privacy-policy'),
                'terms_conditions_url' => url('/terms-conditions'),
                'contact_email' => 'support@sipintar.com'
            ];

            return response()->json([
                'success' => true,
                'message' => 'App information retrieved successfully',
                'data' => $appInfo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve app information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
}
