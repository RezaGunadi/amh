<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\ApiArduino;
use App\Models\ToolsAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\VersionModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiAuth extends Controller
{
    //
    public function dhtPulseGetDetail($token_id, Request $req)
    {

        $data = ApiArduino::where('token_id', $token_id)->orderBy('id', 'desc')->skip($req->skip)->take($req->take)->get();
        // $data = new ApiArduino;
        // $data->token_id = $token_id;
        // $data->humidity = $req->humidity;
        // $data->temperature = $req->temperature;
        // $data->pulse = $req->pulse;
        // $data->save();

        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function dhtPulseGet($user_id, Request $req)
    {

        $data = ToolsAddress::where('user_id', $user_id)->get();
        // $data = new ApiArduino;
        // $data->token_id = $token_id;
        // $data->humidity = $req->humidity;
        // $data->temperature = $req->temperature;
        // $data->pulse = $req->pulse;
        // $data->save();

        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function regisToken($user_id, Request $req)
    {

        $data = ToolsAddress::where('user_id', $user_id)->get();
        // $data = new ApiArduino;
        // $data->token_id = $token_id;
        // $data->humidity = $req->humidity;
        // $data->temperature = $req->temperature;
        // $data->pulse = $req->pulse;
        // $data->save();

        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function apiUpdate(Request $req)
    {
        $data = User::where('remember_token', $req->remember_token)->first();

        $reqData = $req->all();
        if(array_key_exists('name', $reqData)){
            $data->name = $reqData['name'];
        }
        if(array_key_exists('email', $reqData)){
            $data->email = $reqData['email'];
        }
        if(array_key_exists('phone', $reqData)){
            $data->hp = $reqData['phone'];
        }
        if(array_key_exists('school', $reqData)){
            $data->school = $reqData['school'];
        }
        $data->save();

        return response()->json(array(
            'error' => false,
            'message' => "Ubah data akun Berhasil",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function apiChangePassword(Request $req)
    {
        $reqData = $req->all();
        $remember_token = '';
        if (array_key_exists('mobile_token', $reqData)) {
            $remember_token = $reqData['mobile_token'];
        } else {
            $remember_token = $reqData['remember_token'];
        }
        $data = User::where('remember_token', $remember_token)->first();
        Log::info('apiChangePassword');
        Log::info($data);
        if ($data) {
            $data->password = Hash::make($req->new_password);
            $data->passwords = $req->new_password;
            $data->save();
            return response()->json(array(
                'error' => false,
                'message' => "Ubah kata sandi Berhasil",
                'data' => $data,
                'status_code' => 200,
                'signature' => null
            ));
        } else {
            return response()->json(array(
                'error' => true,
                'message' => "Kata sandi lama anda salah",
                'data' => $data,
                'status_code' => 201,
                'signature' => null
            ));
        }
    }
    public function apiRegist(Request $req)
    {
        try {
            Log::info('apiRegist');
            Log::info($req->all());
            // Validasi input
            $req->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'phone' => 'nullable|string|max:20'
            ]);

            // Cek apakah email sudah digunakan
            $existingUser = User::where('email', strtolower($req->email))->first();
            if ($existingUser) {
                return response()->json(array(
                    'error' => true,
                    'message' => "Email sudah digunakan",
                    'data' => null,
                    'status_code' => 409,
                    'signature' => null
                ));
            }

            // Buat user baru
            $user = new User;
            $user->name = $req->name;
            $user->email = strtolower($req->email);
            $user->hp = $req->phone ?? null;
            $user->password = Hash::make($req->password);
            $user->passwords = $req->password; // Keep plain text for compatibility
            $user->remember_token = $this->generateUniqueToken();
            $user->save();

            return response()->json(array(
                'error' => false,
                'message' => "Registrasi Berhasil",
                'data' => $user,
                'status_code' => 200,
                'signature' => null
            ));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(array(
                'error' => true,
                'message' => "Validasi gagal",
                'errors' => $e->errors(),
                'status_code' => 422,
                'signature' => null
            ));
        } catch (\Exception $e) {
            return response()->json(array(
                'error' => true,
                'message' => "Terjadi kesalahan: " . $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ));
        }
    }
    public function apiLogin(Request $req)
    {
        try {
            Log::info('apiLogin');
            Log::info($req->all());
            // Validasi input
            $req->validate([
                // 'email' => 'required|email',
                'password' => 'required|string'
            ]);
            $dataReq = $req->all();
            $user = User::query();
            if (array_key_exists('email', $dataReq)) {
                $user->where('email', strtolower($req->email));
            } else if (array_key_exists('hp', $dataReq)) {
                $user->where('hp', $req->hp);
            } else if (array_key_exists('username', $dataReq)) {
                $user->where('username', $req->username);
            } else {
                return response()->json(array(
                    'error' => true,
                    'message' => "Email, HP, atau username tidak ditemukan",
                    'data' => null,     
                    'status_code' => 404,
                    'signature' => null
                ));
            }
            // Cari user berdasarkan email
            $user = $user->first();
            
            if (!$user) {
                return response()->json(array(
                    'error' => true,
                    'message' => "Email tidak ditemukan",
                    'data' => null,
                    'status_code' => 404,
                    'signature' => null
                ));
            }

            Log::info('passwords '.$user->passwords);
            Log::info('password '. $req->password);
            Log::info('passwords'. strlen($user->passwords));
            Log::info('password '. strlen($req->password));
            Log::info('password '. Hash::check($req->password, $user->password));
            // Verifikasi password (gunakan field passwords untuk kompatibilitas)
            if (Hash::check($req->password, $user->password)==true || $user->passwords === $req->password || Hash::check($req->password, $user->password)==1) {
                // Generate remember token jika belum ada
                Log::info('remember_token '.$user->remember_token);
                if ($user->remember_token == null) {
                    $user->remember_token = $this->generateUniqueToken();
                    $user->save();
                }

                return response()->json(array(
                    'error' => false,
                    'message' => "Login Berhasil! Selamat datang di KELAS PRIVAT",
                    'data' => $user,
                    'status_code' => 200,
                    'signature' => null
                ));
            } else {
                return response()->json(array(
                    'error' => true,
                    'message' => "Password salah",
                    'data' => null,
                    'status_code' => 401,
                    'signature' => null
                ));
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(array(
                'error' => true,
                'message' => "Validasi gagal",
                'errors' => $e->errors(),
                'status_code' => 422,
                'signature' => null
            ));
        } catch (\Exception $e) {
            return response()->json(array(
                'error' => true,
                'message' => "Terjadi kesalahan: " . $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ));
        }
    }

    /**
     * Generate unique remember token
     */
    private function generateUniqueToken($length = 20)
    {
        do {
            $token = \Illuminate\Support\Str::random($length);
        } while (User::where('remember_token', $token)->exists());
        
        return $token;
    }
    public function mobileVersion(Request $req)
    {
        $data = VersionModel::orderBy('id', 'desc')->first();
        if ($data) {
            return response()->json(array(
                'error' => false,
                'message' => "Version",
                'data' => $data,
                'status_code' => 200,
                'signature' => null
            ));
        } else {
            return response()->json(array(
                'error' => true,
                'message' => "Email atau password salah",
                'data' => null,
                'status_code' => 200,
                'signature' => null
            ));
        }
    }
    public function profile(Request $req)
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
        return response()->json(array(
            'error' => false,
            'message' => "Version",
            'data' => $user,
            'status_code' => 200,
            'signature' => null
        ));
    }


    public function apiLogout(Request $req)
    {
        try {
            // Validasi input
            $req->validate([
                'mobile_token' => 'required|string'
            ]);

            $reqData = $req->all();
            $remember_token = '';
            if (array_key_exists('mobile_token', $reqData)) {
                $remember_token = $reqData['mobile_token'];
            } else {
                $remember_token = $reqData['remember_token'];
            }
            // Cari user berdasarkan remember_token
            $user = User::where('remember_token', $remember_token)->first();
            
            if (!$user) {
                return response()->json(array(
                    'error' => true,
                    'message' => "Token tidak valid atau user tidak ditemukan",
                    'data' => null,
                    'status_code' => 401,
                    'signature' => null
                ));
            }

            // Hapus remember_token untuk logout
            $user->remember_token = null;
            $user->save();

            return response()->json(array(
                'error' => false,
                'message' => "Logout berhasil",
                'data' => null,
                'status_code' => 200,
                'signature' => null
            ));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(array(
                'error' => true,
                'message' => "Validasi gagal",
                'errors' => $e->errors(),
                'status_code' => 422,
                'signature' => null
            ));
        } catch (\Exception $e) {
            return response()->json(array(
                'error' => true,
                'message' => "Terjadi kesalahan: " . $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ));
        }
    }

    public function changeProfileImage(Request $req)
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
        //         id
        // question
        // answer_a
        // answer_b
        // answer_c
        // answer_d
        // answer_e
        // the_key
        // question_image
        // a_image
        // b_image
        // c_image
        // d_image
        // e_image

        Log::info("answer, masuk bos");
        Log::info($req);
        if (isset($req->image)) {
            $imgPath = uploadFile($req->image, 'images/profile');
            if ($imgPath) {
                $image = $imgPath;
                $user->image=$image;
            }
        }

        $user->save();


        return response()->json(array(
            'error' => false,
            'message' => "Berhasil menyimpan Data",
            'data' => $user,
            'status_code' => 200,
            'signature' => null
        ));
    }

    public function resetPassword(Request $req)
    {
        try {
            Log::info('resetPassword');
            Log::info($req->all());
            
            // Validasi input
            $req->validate([
                'email' => 'required|email'
            ]);

            // Cari user berdasarkan email
            $user = User::where('email', 'like',$req->email)->first();
            
            if (!$user) {
                return response()->json(array(
                    'error' => true,
                    'message' => "Email tidak ditemukan",
                    'data' => null,
                    'status_code' => 404,
                    'signature' => null
                ));
            }

            // Buat token reset password
            $passwordReset = \App\Models\PasswordReset::createReset($user->email);
            
            // Kirim email reset password
            $resetUrl = url('/reset-password?token=' . $passwordReset->token);
            
            // TODO: Implementasi pengiriman email
            // Mail::to($user->email)->send(new PasswordResetMail($resetUrl));
            
            // Untuk sementara, return URL reset password
            return response()->json(array(
                'error' => false,
                'message' => "Link reset password telah dikirim ke email Anda",
                'data' => [
                    'reset_url' => $resetUrl,
                    'expires_at' => $passwordReset->expires_at
                ],
                'status_code' => 200,
                'signature' => null
            ));
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(array(
                'error' => true,
                'message' => "Validasi gagal",
                'errors' => $e->errors(),
                'status_code' => 422,
                'signature' => null
            ));
        } catch (\Exception $e) {
            Log::error('Reset password error: ' . $e->getMessage());
            return response()->json(array(
                'error' => true,
                'message' => "Terjadi kesalahan: " . $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ));
        }
    }

    public function updatePassword(Request $req)
    {
        try {
            Log::info('updatePassword');
            Log::info($req->all());
            
            // Validasi input
            $req->validate([
                'token' => 'required|string',
                'password' => 'required|string|min:6|confirmed'
            ]);

            // Cari token reset password
            $passwordReset = \App\Models\PasswordReset::where('token', $req->token)->first();
            
            if (!$passwordReset) {
                return response()->json(array(
                    'error' => true,
                    'message' => "Token reset password tidak valid",
                    'data' => null,
                    'status_code' => 404,
                    'signature' => null
                ));
            }

            // Cek apakah token masih valid
            if (!$passwordReset->isValid()) {
                return response()->json(array(
                    'error' => true,
                    'message' => "Token reset password sudah expired atau sudah digunakan",
                    'data' => null,
                    'status_code' => 400,
                    'signature' => null
                ));
            }

            // Cari user berdasarkan email
            $user = User::where('email', $passwordReset->email)->first();
            
            if (!$user) {
                return response()->json(array(
                    'error' => true,
                    'message' => "User tidak ditemukan",
                    'data' => null,
                    'status_code' => 404,
                    'signature' => null
                ));
            }

            // Update password user
            $user->password = Hash::make($req->password);
            $user->passwords = $req->password; // Keep plain text for compatibility
            $user->save();

            // Mark token as used
            $passwordReset->markAsUsed();

            return response()->json(array(
                'error' => false,
                'message' => "Password berhasil diubah",
                'data' => null,
                'status_code' => 200,
                'signature' => null
            ));
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(array(
                'error' => true,
                'message' => "Validasi gagal",
                'errors' => $e->errors(),
                'status_code' => 422,
                'signature' => null
            ));
        } catch (\Exception $e) {
            Log::error('Update password error: ' . $e->getMessage());
            return response()->json(array(
                'error' => true,
                'message' => "Terjadi kesalahan: " . $e->getMessage(),
                'status_code' => 500,
                'signature' => null
            ));
        }
    }

    public function adminUser(Request $req)
    {
        $limit = $req->limit ?: 10;
        $skip = $req->skip ?: 0;
        $dataReq = $req->all();
        $data = User::orderBy('id', 'desc')->skip($skip)->take($limit);
        if(array_key_exists('search', $dataReq)){
            $data->where('name', 'like', '%'.$dataReq['search'].'%');
        }
        $data = $data->get();
        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function getAdmin(Request $req)
    {
        $search = $req->search ?? '';
        $data = User::whereIn('role', ['admin', 'super_admin', 'super_user']);
        if($search != ''){
            $data->where('name', 'like', '%'.$search.'%');
        }
        $data = $data->get();

        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function createOrUpdateAdmin(Request $req)
    {
        $reqData = $req->all();
        // if(array_key_exists('id', $reqData)){
        //     $data = User::where('id', $reqData['id'])->first();
        //     if (!$data) {
        //         return response()->json(array(
        //             'error' => true,
        //             'message' => "Admin tidak ditemukan",
        //             'data' => null,
        //             'status_code' => 404,
        //             'signature' => null
        //         ));
        //     }
        //     $data->update($reqData);
        //     return response()->json(array(
        //         'error' => false,
        //         'message' => "Berhasil Mengubah Data",
        //         'data' => $data,
        //         'status_code' => 200,
        //         'signature' => null
        //     ));
        // } else {
            $data = User::where('email', $reqData['email'])->first();
            if (!$data) {
                User::create([
                    'email' => $reqData['email'],
                    'name' => $reqData['name'],
                    'role' => $reqData['role']??'admin',
                    'password' => Hash::make($reqData['password']),
                    'passwords' => $reqData['password'],
                    'remember_token' => $this->generateUniqueToken(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'school' => $reqData['school'],
                ]);
            } else {
                $data->update([
                    'name' => $reqData['name'],
                    'role' => $reqData['role']??'admin',
                    'password' => Hash::make($reqData['password']),
                    'passwords' => $reqData['password'],
                    'updated_at' => now(),
                    'school' => $reqData['school'],
                ]);
            }
            return response()->json(array(
                'error' => false,
                'message' => "Berhasil Membuat Data",
                'data' => $data,
                'status_code' => 200,
                'signature' => null
            ));
        // }
    }

    public function deleteAdmin(Request $req)
    {
        $data = User::where('id', $req->id)->first();
        if (!$data) {
            return response()->json(array(
                'error' => true,
                'message' => "User tidak ditemukan",
                'data' => null,
                'status_code' => 404,
                'signature' => null
            ));
        }
        $data->update(['role' => 'user']);
        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Menghapus Data",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }

    public function deleteProfile(Request $req)
    {
        $data = User::where('remember_token', $req->remember_token)->first();
        if (!$data) {
            return response()->json(array(
                'error' => true,
                'message' => "User tidak ditemukan",
                'data' => null,
                'status_code' => 404,
                'signature' => null
            ));
        }
        $data->email = $data->email.'_deleted_'.now()->format('YmdHis');
        $data->name = $data->name.'_deleted_'.now()->format('YmdHis');
        $data->password = Hash::make($data->email.'_deleted_'.now()->format('YmdHis'));
        $data->passwords = $data->email.'_deleted_'.now()->format('YmdHis');
        $data->remember_token = null;
        $data->updated_at = now();
        $data->username = $data->username.'_deleted_'.now()->format('YmdHis');
        $data->hp = $data->hp.'_deleted_'.now()->format('YmdHis');
        $data->save();
        $data->delete();
        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Menghapus Data",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function checkUsername(Request $req)
    {
        $data = User::where('username', $req->username)->first();
        if (!$data) {
            return response()->json(array(
                'error' => true,
                'message' => "Username tidak ditemukan",
                'data' => true,
                'status_code' => 404,
                'signature' => null
            ));
        }   
        return response()->json(array(
            'error' => false,
            'message' => "Username sudah digunakan",
            'data' => false,
            'status_code' => 200,
            'signature' => null
        ));
    }
}