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
     * Show delete account page
     */
    public function index(Request $request)
    {
        // Get user from remember_token or session
        $user = null;
        
        if ($request->has('token')) {
            $user = User::where('remember_token', $request->token)->first();
        } elseif (Auth::check()) {
            $user = Auth::user();
        }
        
        return view('delete_account', [
            'title' => 'Hapus Akun - amhriset',
            'user' => $user,
            'token' => $request->token
        ]);
    }

    /**
     * Process account deletion
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'password' => 'required|string',
            'confirmation' => 'required|accepted'
        ], [
            'token.required' => 'Token autentikasi diperlukan',
            'password.required' => 'Password diperlukan untuk konfirmasi',
            'confirmation.accepted' => 'Anda harus menyetujui penghapusan akun'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('remember_token', $request->token)->first();
        
        if (!$user) {
            return back()->withErrors(['error' => 'Token tidak valid atau akun tidak ditemukan'])->withInput();
        }

        // Verify password
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

        // Logout if authenticated via session
        if (Auth::check() && Auth::id() == $user->id) {
            Auth::logout();
        }

        return redirect('/')->with('success', 'Akun berhasil dihapus. Semua data telah dihapus secara permanen.');
    }
}

