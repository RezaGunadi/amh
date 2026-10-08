<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HelpRequest;

class NewsController extends Controller
{
    public function helpRequest(Request $req)
    {
        $reqData = $req->all();
        $remember_token = '';
        if (array_key_exists('mobile_token', $reqData)) {
            $remember_token = $reqData['mobile_token'];
        } else {
            $remember_token = $reqData['remember_token'];
        }
        $user = User::where('remember_token', $remember_token)->where('role', "ADMIN")->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        $take = 10;
        $skip = 0;
        if ($req->has('take')) {
            $take = $req->take;
        }
        if ($req->has('skip')) {
            $skip = $req->skip;
        }
        $data = HelpRequest::orderBy('id', 'desc')->take($take)->skip($skip)->where('is_deleted',0)->get();
        
        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }


}
// /api/arduino/dht-pulse/{token}?humidity=12&temperature=12&pulse=12