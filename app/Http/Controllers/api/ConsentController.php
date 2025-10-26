<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ConsentController extends Controller
{
    /**
     * Get consent information
     */
    public function getConsentInfo(): JsonResponse
    {
        try {
            $consentInfo = [
                'data_collection' => [
                    'profile_data' => [
                        'purpose' => 'To provide personalized experience and track your food preferences',
                        'required' => true,
                        'data_types' => ['name', 'email', 'username', 'school']
                    ],
                    'usage_analytics' => [
                        'purpose' => 'To improve app performance and user experience',
                        'required' => false,
                        'data_types' => ['app_usage', 'feature_interactions', 'performance_metrics']
                    ],
                    'location_data' => [
                        'purpose' => 'To provide location-based content and recommendations',
                        'required' => false,
                        'data_types' => ['general_location', 'country', 'region']
                    ],
                    'device_information' => [
                        'purpose' => 'To ensure app compatibility and provide technical support',
                        'required' => true,
                        'data_types' => ['device_type', 'os_version', 'app_version']
                    ]
                ],
                'data_sharing' => [
                    'third_party_services' => [
                        'google_analytics' => [
                            'purpose' => 'App usage analytics and performance monitoring',
                            'data_shared' => ['usage_statistics', 'crash_reports'],
                            'required' => false
                        ],
                        'cloud_storage' => [
                            'purpose' => 'Data backup and synchronization',
                            'data_shared' => ['user_data', 'preferences'],
                            'required' => true
                        ]
                    ]
                ],
                'user_rights' => [
                    'access_data' => 'You can request a copy of your data at any time',
                    'correct_data' => 'You can update your profile information',
                    'delete_data' => 'You can delete your account and all associated data',
                    'withdraw_consent' => 'You can change your consent preferences at any time',
                    'data_portability' => 'You can export your data in a machine-readable format'
                ],
                'retention_periods' => [
                    'account_data' => 'Until account deletion',
                    'usage_analytics' => '24 months',
                    'support_communications' => '3 years',
                    'legal_obligations' => 'As required by law'
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Consent information retrieved successfully',
                'data' => $consentInfo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve consent information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user consent preferences
     */
    public function updateConsent(Request $request): JsonResponse
    {
        try {
            $validator = \Validator::make($request->all(), [
                'usage_analytics' => 'boolean',
                'location_data' => 'boolean',
                'marketing_communications' => 'boolean',
                'data_sharing' => 'boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();

            // Update user consent preferences
            $consentData = [
                'usage_analytics_consent' => $request->get('usage_analytics', false),
                'location_data_consent' => $request->get('location_data', false),
                'marketing_consent' => $request->get('marketing_communications', false),
                'data_sharing_consent' => $request->get('data_sharing', false),
                'consent_updated_at' => now()
            ];

            $user->update($consentData);

            return response()->json([
                'success' => true,
                'message' => 'Consent preferences updated successfully',
                'data' => [
                    'usage_analytics' => $user->usage_analytics_consent,
                    'location_data' => $user->location_data_consent,
                    'marketing_communications' => $user->marketing_consent,
                    'data_sharing' => $user->data_sharing_consent,
                    'updated_at' => $user->consent_updated_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update consent preferences',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current user consent status
     */
    public function getConsentStatus(): JsonResponse
    {
        try {
            $user = Auth::user();

            $consentStatus = [
                'usage_analytics' => $user->usage_analytics_consent ?? false,
                'location_data' => $user->location_data_consent ?? false,
                'marketing_communications' => $user->marketing_consent ?? false,
                'data_sharing' => $user->data_sharing_consent ?? false,
                'consent_updated_at' => $user->consent_updated_at,
                'privacy_policy_accepted' => $user->privacy_policy_accepted ?? false,
                'terms_accepted' => $user->terms_accepted ?? false
            ];

            return response()->json([
                'success' => true,
                'message' => 'Consent status retrieved successfully',
                'data' => $consentStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve consent status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Accept privacy policy and terms
     */
    public function acceptTermsAndPrivacy(Request $request): JsonResponse
    {
        try {
            $validator = \Validator::make($request->all(), [
                'privacy_policy' => 'required|boolean|accepted',
                'terms_conditions' => 'required|boolean|accepted'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();

            $user->update([
                'privacy_policy_accepted' => true,
                'terms_accepted' => true,
                'privacy_policy_accepted_at' => now(),
                'terms_accepted_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Terms and privacy policy accepted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to accept terms and privacy policy',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Withdraw consent
     */
    public function withdrawConsent(Request $request): JsonResponse
    {
        try {
            $validator = \Validator::make($request->all(), [
                'consent_type' => 'required|string|in:usage_analytics,location_data,marketing_communications,data_sharing'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $consentType = $request->consent_type;

            $updateData = [
                $consentType . '_consent' => false,
                'consent_updated_at' => now()
            ];

            $user->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Consent withdrawn successfully',
                'data' => [
                    'consent_type' => $consentType,
                    'status' => 'withdrawn',
                    'updated_at' => $user->consent_updated_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to withdraw consent',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
