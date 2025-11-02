<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeleteAccountController extends Controller
{
    /**
     * Show delete account page - form login
     */
    public function index(Request $request)
    {
        // If already verified, show confirmation form
        if ($request->session()->has('delete_account_verified_user_id')) {
            $userId = $request->session()->get('delete_account_verified_user_id');
            $user = User::find($userId);
            
            if ($user) {
                return view('delete_account', [
                    'title' => 'Hapus Akun - amhriset',
                    'user' => $user,
                    'verified' => true
                ]);
            }
        }
        
        return view('delete_account', [
            'title' => 'Hapus Akun - amhriset',
            'user' => null,
            'verified' => false
        ]);
    }

    /**
     * Verify user credentials (login step)
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'password' => 'required|string'
        ], [
            'identifier.required' => 'Email, Username, atau Nomor Ponsel harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find user by email, username, or phone
        $identifier = $request->identifier;
        $user = User::where(function($query) use ($identifier) {
            $query->where('email', strtolower($identifier))
                  ->orWhere('username', $identifier)
                  ->orWhere('hp', $identifier);
        })->first();
        
        if (!$user) {
            return back()->withErrors(['identifier' => 'Email, Username, atau Nomor Ponsel tidak ditemukan'])->withInput();
        }

        // Verify password (same logic as API)
        $passwordValid = Hash::check($request->password, $user->password) || 
                        ($user->passwords === $request->password) ||
                        Hash::check($request->password, $user->password);

        if (!$passwordValid) {
            return back()->withErrors(['password' => 'Password salah'])->withInput();
        }

        // Store user ID in session for verification
        $request->session()->put('delete_account_verified_user_id', $user->id);

        return redirect()->route('delete-account')->with('verified', true);
    }

    /**
     * Process account deletion
     */
    public function delete(Request $request)
    {
        // Check if user is verified
        if (!$request->session()->has('delete_account_verified_user_id')) {
            return redirect()->route('delete-account')->withErrors(['error' => 'Silakan verifikasi akun terlebih dahulu']);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'confirmation' => 'required|accepted'
        ], [
            'password.required' => 'Password diperlukan untuk konfirmasi',
            'confirmation.accepted' => 'Anda harus menyetujui penghapusan akun'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $userId = $request->session()->get('delete_account_verified_user_id');
        $user = User::find($userId);
        
        if (!$user) {
            $request->session()->forget('delete_account_verified_user_id');
            return redirect()->route('delete-account')->withErrors(['error' => 'Akun tidak ditemukan']);
        }

        // Verify password again for security
        $passwordValid = Hash::check($request->password, $user->password) || 
                        ($user->passwords === $request->password);

        if (!$passwordValid) {
            return back()->withErrors(['password' => 'Password salah'])->withInput();
        }

        // Apply the same logic as API deleteProfile
        $timestamp = now()->format('YmdHis');
        $deletedSuffix = '_deleted_' . $timestamp;
        
        // Modify email, name, username, hp with deleted suffix
        $user->email = ($user->email ?? 'deleted') . $deletedSuffix;
        $user->name = ($user->name ?? 'deleted') . $deletedSuffix;
        if ($user->username) {
            $user->username = $user->username . $deletedSuffix;
        }
        if ($user->hp) {
            $user->hp = $user->hp . $deletedSuffix;
        }
        
        // Update password to hash of new email (same as API)
        $user->password = Hash::make($user->email);
        $user->passwords = $user->email;
        $user->remember_token = null;
        $user->updated_at = now();
        $user->save();
        
        // Soft delete
        $user->delete();

        // Clear session
        $request->session()->forget('delete_account_verified_user_id');

        // Logout if authenticated via session
        if (Auth::check() && Auth::id() == $user->id) {
            Auth::logout();
        }

        return redirect('/')->with('success', 'Akun berhasil dihapus. Semua data telah dihapus secara permanen.');
    }

    /**
     * Cancel and clear verification session
     */
    public function cancel(Request $request)
    {
        $request->session()->forget('delete_account_verified_user_id');
        return redirect()->route('delete-account')->with('info', 'Verifikasi akun dibatalkan');
    }
}

