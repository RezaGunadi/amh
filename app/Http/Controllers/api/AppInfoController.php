<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\JsonResponse;
use App\Models\Favorite;
use App\Models\History;
use App\Models\User;

class AppInfoController extends Controller
{
    /**
     * Get app information and metadata
     */
    public function getAppInfo(): JsonResponse
    {
        try {
            $appInfo = [
                'app' => [
                    'name' => 'Sipintar',
                    'version' => '1.0.0',
                    'build_number' => '1',
                    'package_name' => 'com.sipintar.app',
                    'bundle_id' => 'com.sipintar.app',
                    'description' => 'Aplikasi edukasi nutrisi untuk belajar dan tracking konsumsi makanan',
                    'category' => 'Education',
                    'age_rating' => '4+',
                    'languages' => ['id', 'en'],
                    'supported_platforms' => ['android', 'ios']
                ],
                'features' => [
                    'guest_access' => [
                        'browse_menu' => true,
                        'view_nutrition' => true,
                        'search_food' => true,
                        'view_categories' => true,
                        'educational_content' => true
                    ],
                    'authenticated_features' => [
                        'favorites' => true,
                        'history_tracking' => true,
                        'personalized_recommendations' => true,
                        'account_management' => true,
                        'data_export' => true
                    ]
                ],
                'privacy' => [
                    'privacy_policy_url' => url('/privacy-policy'),
                    'terms_conditions_url' => url('/terms-conditions'),
                    'data_retention_policy' => 'User data is retained until account deletion',
                    'gdpr_compliant' => true,
                    'ccpa_compliant' => true,
                    'data_encryption' => true
                ],
                'support' => [
                    'email' => 'support@sipintar.com',
                    'website' => 'https://sipintar.com',
                    'response_time' => '24-48 hours',
                    'faq_available' => true,
                    'user_guide' => true
                ],
                'legal' => [
                    'developer' => 'Sipintar Team',
                    'copyright' => '© 2025 Sipintar. All rights reserved.',
                    'license' => 'Proprietary',
                    'trademark' => 'Sipintar™'
                ],
                'technical' => [
                    'min_android_version' => '5.0 (API 21)',
                    'min_ios_version' => '12.0',
                    'target_android_version' => '14 (API 34)',
                    'target_ios_version' => '17.0',
                    'permissions' => [
                        'internet' => 'Required for app functionality',
                        'storage' => 'Optional for offline content',
                        'location' => 'Optional for regional content'
                    ]
                ],
                'content_rating' => [
                    'age_rating' => '4+',
                    'content_descriptors' => [],
                    'interactive_elements' => ['Shares Info', 'Users Interact'],
                    'category' => 'Education'
                ]
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

    /**
     * Get app version information
     */
    public function getVersionInfo(): JsonResponse
    {
        try {
            $versionInfo = [
                'current_version' => '1.0.0',
                'build_number' => '1',
                'release_date' => '2025-10-14',
                'release_notes' => [
                    '🎉 Sipintar resmi diluncurkan!',
                    '✨ Fitur baru:',
                    '• Browse menu makanan tanpa login',
                    '• Informasi nutrisi lengkap',
                    '• Tracking konsumsi harian',
                    '• Favorites dan history',
                    '• Konten edukasi nutrisi',
                    '• Privacy-first approach',
                    '🛡️ Keamanan & Privasi:',
                    '• Data Anda aman dan terlindungi',
                    '• Kontrol penuh atas data pribadi',
                    '• Memenuhi standar GDPR dan CCPA'
                ],
                'update_required' => false,
                'force_update' => false,
                'maintenance_mode' => false,
                'supported_versions' => ['1.0.0'],
                'deprecated_versions' => []
            ];

            return response()->json([
                'success' => true,
                'message' => 'Version information retrieved successfully',
                'data' => $versionInfo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve version information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get app configuration
     */
    public function getAppConfig(): JsonResponse
    {
        try {
            $config = [
                'features' => [
                    'guest_mode_enabled' => true,
                    'analytics_enabled' => true,
                    'crash_reporting_enabled' => true,
                    'push_notifications_enabled' => false,
                    'offline_mode_enabled' => false,
                    'social_login_enabled' => true,
                    'biometric_auth_enabled' => false
                ],
                'api' => [
                    'base_url' => url('/api'),
                    'version' => 'v1',
                    'timeout' => 30,
                    'retry_attempts' => 3
                ],
                'ui' => [
                    'theme' => 'light',
                    'language' => 'id',
                    'font_size' => 'medium',
                    'animations_enabled' => true
                ],
                'privacy' => [
                    'data_collection_enabled' => true,
                    'analytics_enabled' => true,
                    'crash_reporting_enabled' => true,
                    'user_consent_required' => true
                ],
                'limits' => [
                    'max_favorites' => 1000,
                    'max_history_days' => 365,
                    'max_search_results' => 100,
                    'max_file_upload_size' => '10MB'
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'App configuration retrieved successfully',
                'data' => $config
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve app configuration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get store information
     */
    public function getStoreInfo(): JsonResponse
    {
        try {
            $storeInfo = [
                'play_store' => [
                    'available' => true,
                    'url' => 'https://play.google.com/store/apps/details?id=com.sipintar.app',
                    'rating' => null,
                    'review_count' => 0,
                    'download_count' => 0,
                    'last_updated' => null
                ],
                'app_store' => [
                    'available' => true,
                    'url' => 'https://apps.apple.com/app/sipintar/id123456789',
                    'rating' => null,
                    'review_count' => 0,
                    'download_count' => 0,
                    'last_updated' => null
                ],
                'direct_download' => [
                    'available' => false,
                    'url' => null,
                    'version' => null
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Store information retrieved successfully',
                'data' => $storeInfo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve store information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get app statistics (for admin)
     */
    public function getAppStats(): JsonResponse
    {
        try {
            // This would typically require authentication and admin role
            $stats = [
                'users' => [
                    'total' => \App\Models\User::count(),
                    'active_today' => \App\Models\User::whereDate('last_login_at', today())->count(),
                    'new_this_week' => \App\Models\User::where('created_at', '>=', now()->subWeek())->count()
                ],
                'content' => [
                    'total_menu' => \App\Models\MenuMakanan::count(),
                    'active_menu' => \App\Models\MenuMakanan::where('is_active', true)->count(),
                    'total_categories' => \App\Models\MenuMakanan::distinct('kategori')->count()
                ],
                'engagement' => [
                    'total_favorites' => Favorite::count(),
                    'total_history' => History::count(),
                    'total_searches' => 0 // Would need to implement search tracking
                ],
                'privacy' => [
                    'consent_given' => \App\Models\User::where('privacy_policy_accepted', true)->count(),
                    'data_export_requests' => 0, // Would need to implement tracking
                    'account_deletions' => \DB::table('delete_account_requests')->where('status', 'completed')->count()
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'App statistics retrieved successfully',
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve app statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
