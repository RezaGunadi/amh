<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ApiArduino;
use App\Models\ToolsAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthOld extends Controller
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
    protected function apiUpdate(Request $req)
    {
        $data = User::where('remember_token', $req->remember_token)->first();

        $data->name = $req['name'];
        $data->email = $req['email'];
        $data->hp = $req['phone'];
        $data->save();

        return response()->json(array(
            'error' => false,
            'message' => "Ubah data akun Berhasil",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
    protected function apiChangePassword(Request $req)
    {
        $data = User::where('remember_token', $req->remember_token)->first();
        if ($data->passwords == $req['password']) {

            $data->password = Hash::make($req['new_password']);
            $data->passwords = $req['new_password'];
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
    protected function apiRegist(Request $req)
    {
        $random = Helpers::generateRandomString(10);
        $cekUser = User::where('remember_token', $random)->first();
        if ($cekUser) {
            # code...
            for ($i = 0; $i < 9999999; $i++) {
                # code...

                $random = Helpers::generateRandomString(10);
                $cekLoop = User::where('remember_token', $random)->first();
                if (!$cekLoop) {
                    # code...
                    break;
                }
            }
        }
        $data = new User;
        $data->name = $req['name'];
        $data->email = $req['email'];
        $data->hp = $req['phone'];
        $data->phone = $req['phone'];
        $data->password = Hash::make($req['password']);
        $data->passwords = $req['password'];
        $data->remember_token = $random;
        $data->save();

        return response()->json(array(
            'error' => false,
            'message' => "Registrasi Berhasil",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
    protected function apiLogin(Request $req)
    {
        $data = User::where('email', $req->email)->where('passwords', $req->password)->first();
        if ($data) {
            return response()->json(array(
                'error' => false,
                'message' => "Login Berhasil",
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

        return response()->json(array(
            'error' => false,
            'message' => "Login Berhasil",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
}
// /api/arduino/dht-pulse/{token}?humidity=12&temperature=12&pulse=12