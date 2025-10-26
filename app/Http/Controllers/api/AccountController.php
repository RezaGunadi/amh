<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DeleteAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Delete user account with confirmation
     */
    public function deleteAccount(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string',
                'reason' => 'nullable|string|max:1000',
                'confirmation' => 'required|boolean|accepted'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            
            // Verify password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid password'
                ], 401);
            }

            // Check confirmation
            if (!$request->confirmation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Account deletion must be confirmed'
                ], 400);
            }

            DB::beginTransaction();

            try {
                // Create delete account request
                $deleteRequest = DeleteAccountRequest::create([
                    'user_id' => $user->id,
                    'reason' => $request->reason,
                    'status' => 'pending',
                    'processed_at' => now(),
                    'processed_by' => null // Self-deletion
                ]);

                // Mark user for deletion
                $user->update([
                    'deletion_requested_at' => now()
                ]);

                // Delete user data
                $this->deleteUserData($user);

                // Logout user
                Auth::logout();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Account deletion request submitted successfully. Your account will be permanently deleted within 30 days.'
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete account',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Request account deletion (for admin review)
     */
    public function requestAccountDeletion(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'reason' => 'required|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();

            // Check if user already has a pending request
            $existingRequest = DeleteAccountRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have a pending account deletion request'
                ], 400);
            }

            // Create delete account request
            $deleteRequest = DeleteAccountRequest::create([
                'user_id' => $user->id,
                'reason' => $request->reason,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Account deletion request submitted successfully. Our team will review your request within 7 business days.',
                'data' => [
                    'request_id' => $deleteRequest->id,
                    'status' => $deleteRequest->status,
                    'submitted_at' => $deleteRequest->created_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit account deletion request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get account deletion request status
     */
    public function getDeletionRequestStatus(): JsonResponse
    {
        try {
            $user = Auth::user();

            $deleteRequest = DeleteAccountRequest::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$deleteRequest) {
                return response()->json([
                    'success' => true,
                    'message' => 'No deletion request found',
                    'data' => null
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Deletion request status retrieved successfully',
                'data' => [
                    'id' => $deleteRequest->id,
                    'status' => $deleteRequest->status,
                    'reason' => $deleteRequest->reason,
                    'submitted_at' => $deleteRequest->created_at,
                    'processed_at' => $deleteRequest->processed_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve deletion request status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel account deletion request
     */
    public function cancelDeletionRequest(): JsonResponse
    {
        try {
            $user = Auth::user();

            $deleteRequest = DeleteAccountRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->first();

            if (!$deleteRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'No pending deletion request found'
                ], 404);
            }

            $deleteRequest->update([
                'status' => 'cancelled',
                'processed_at' => now()
            ]);

            // Remove deletion request marker from user
            $user->update([
                'deletion_requested_at' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Account deletion request cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel deletion request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user data for export (GDPR compliance)
     */
    public function exportUserData(): JsonResponse
    {
        try {
            $user = Auth::user();

            $userData = [
                'profile' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'school' => $user->school,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at
                ],
                'favorites' => $user->favorites()->with('menuMakanan')->get(),
                'history' => $user->history()->with('menuMakanan')->get(),
                'delete_requests' => $user->deleteAccountRequests()->get()
            ];

            return response()->json([
                'success' => true,
                'message' => 'User data exported successfully',
                'data' => $userData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export user data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete user data (helper method)
     */
    private function deleteUserData(User $user): void
    {
        // Delete user's favorites
        $user->favorites()->delete();

        // Delete user's history
        $user->history()->delete();

        // Delete user's delete requests
        $user->deleteAccountRequests()->delete();

        // Delete user account
        $user->delete();
    }
}
