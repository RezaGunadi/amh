<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\ToolsAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\AnswerPackages;
use App\Models\Image;
use App\Models\jawaban;
use App\Models\news;
use App\Models\PaketSoal;
use App\Models\ShareManagerDB;
use App\Models\soal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use ShareManager;

class LeaderBoardController extends Controller
{
    //
    public function leaderBoard(Request $req)
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
        if ($req->type == 'user') {

            $data = jawaban::join('users', 'users.id', '=', 'jawabans.user_id')
                ->groupBy('jawabans.user_id')
                ->select('users.name', 'users.id', 'users.image', 'jawabans.user_id', DB::raw('COUNT(jawabans.user_id) as sub_total'))
                ->where('is_true', 1)->orderBy('sub_total','desc')->skip($req->skip)->take($req->take)->get();
                foreach ($data as  $value) {
                    # code...
                    $value->total = jawaban::where("user_id", $value->user_id)->groupBy('id_soal')->count();
                }
        } else {
            $data = PaketSoal::
                join('jawabans', 'paket_soals.id', '=', 'jawabans.id_paket')
                ->
                join('users', 'users.id', '=', 'paket_soals.user_id')
                ->groupBy('users.id',)
                // DB::raw('COUNT(paket_soals.user_id) as sub_total'),
                ->select('users.name', 'users.id', 'users.image', 'paket_soals.user_id',  DB::raw('COUNT(paket_soals.id) as total'))
                ->where('is_true', 1)
                ->orderBy('total','desc')
                ->skip($req->skip)->take($req->take)->get();
            foreach ($data as  $value) {
                # code...
                $value->sub_total = PaketSoal::where("paket_soals.user_id", $value->user_id)->groupBy('jawabans.id_paket')-> join('jawabans', 'paket_soals.id', '=', 'jawabans.id_paket')->where('jawabans.is_true', 1)->count();
            }
        }
       
        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $data,
            'status_code' => 200,
            'signature' => null
        ));
    }
}
