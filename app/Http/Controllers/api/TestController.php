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

class TestController extends Controller
{
    //
    public function list(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        $paket = PaketSoal::where('is_deleted', 0);
        $role = 'null';
        $take = 10;
        $skip = 0;
        $jenjang = '';
        $mapel = '';
        $tahun = '';
        $search = '';
        if ($req->has('take')) {
            $take = $req->take;
        }
        if ($req->has('skip')) {
            $skip = $req->skip;
        }
        if ($req->has('jenjang')) {
            $jenjang = $req->jenjang;
        }
        if ($req->has('mapel')) {
            $mapel = $req->mapel;
        }
        if ($req->has('tahun')) {
            $tahun = $req->tahun;
        }
        if ($req->has('search')) {
            $search = $req->search;
        }
        if($jenjang!=''){

            $paket = $paket->where('jenjang', $jenjang);
        }
        if($mapel!=''){

            $paket = $paket->where('mapel', $mapel);
        }
        if($tahun!=''){

            $paket = $paket->where('tahun', $tahun);
        }
        if($search!=''){

            $paket = $paket->where('name', 'LIKE', '%' . $search . '%');
        }
        if ($user->role == null) {
            # code...
            $paket = $paket->where('user_id', 1);
        } else {
            # code...
            $role = $user->role;
            if ($role == 'ADMIN') {
                # code...

            } else if ($role == 'SISWA') {
                # code...
                $paket = $paket->where('is_public', 1);

                if ($user->id != 92) {
                    # code...

                    $paket = $paket->where('user_id', '<>', 92);
                }
            } else {
                $paket = $paket->where(function ($query) use ($role) {
                    $query->where('user_id', $role)->orWhere('user_id', 1);
                    # code...
                });
                if ($user->id != 92) {
                    # code...

                    $paket = $paket->where('user_id', '<>', 92);
                }
            }
        }
        $paket = $paket->orderBy('id', 'desc')->take($take)->skip($skip)->get();
        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $paket,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function myTest(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        $paket = PaketSoal::where('is_deleted', 0);
        $role = 'null';
        $take = 10;
        $skip = 0;
        if ($req->has('take')) {
            $take = $req->take;
        }
        if ($req->has('skip')) {
            $skip = $req->skip;
        }



        $paket = $paket->where('user_id', $user->id)->orderBy('id', 'desc')->take($take)->skip($skip)->get();
        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $paket,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function detail(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        $soal = soal::where('paket_id', $req->test_id)->where('is_deleted', 0)->orderBy('id', 'asc')
            // ->orderBy('id','desc')
            ->get();

        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $soal,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function detailHistory(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }


        $answer = AnswerPackages::
        // where('user_id', $user->id)->
        where('id', $req->test_history_id)->first();
        $soal = soal::where('paket_id', $answer->package_id)->where('is_deleted', 0)->orderBy('id', 'asc')
            // ->orderBy('id','desc')
            ->get();
        $jawaban = jawaban::where('answer_id', $answer->id)->orderBy('id_soal', 'asc')->get();
        foreach ($soal as  $value) {
            # code...
            foreach ($jawaban as  $value2) {
                # code...
                if ($value->id == $value2->id_soal) {
                    # code...
                    $value->user_choose  = $value2->jawaban;
                }
            }
        }
        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $soal,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function answer(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        Log::info("answer, masuk bos");
        Log::info($req);
        $answer = new AnswerPackages();
        $answer->user_id = $user->id;
        $answer->package_id = $req->test_id;
        if ($req->has('tutor_id')) {

            $answer->tutor_id = $req->tutor_id;
        } else {
            $answer->tutor_id = 0;
        }
        $answer->save();
        foreach ($req->answer as  $value) {
            # code...
            $answerEachQuestion = new jawaban();
            $answerEachQuestion->user_id = $user->id;
            $answerEachQuestion->id_soal = $value['id'];
            $answerEachQuestion->id_paket = $req->test_id;
            $answerEachQuestion->answer_id = $answer->id;
            $answerEachQuestion->kunci = $value['key'];
            $answerEachQuestion->jawaban = $value['answer'];
            $answerEachQuestion->is_true = strtolower($value['key']) == strtolower($value['answer']) ? 1 : 0;
            $answerEachQuestion->save();
        }

        return response()->json(array(
            'error' => false,
            'message' => "Berhasil menyimpan Data",
            'data' => $answer,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function getAnswer(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        Log::info("getAnswer, masuk bos");
        Log::info($req);
        $answer = AnswerPackages::where('answer_packages.user_id', $user->id);
        $take = 10;
        $skip = 0;
        if ($req->has('take')) {
            $take = $req->take;
        }
        if ($req->has('skip')) {
            $skip = $req->skip;
        }
        $answer = $answer->join('paket_soals', 'paket_soals.id', '=', 'answer_packages.package_id');
        $answer = $answer->select('paket_soals.*', 'answer_packages.id as test_history_id', 'answer_packages.created_at as test_created_at');
        $answer = $answer->orderBy('id', 'desc')->take($take)->skip($skip)->get();

        return response()->json(array(
            'error' => false,
            'message' => "Berhasil menyimpan Data",
            'data' => $answer,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function createTestPackage(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        Log::info("answer, masuk bos");
        Log::info($req);
        $package = new PaketSoal();
        $package->user_id = $user->id;
        $package->name = $req->name;
        $package->jenjang = $req->jenjang;
        $package->mapel = $req->mapel;
        $package->tahun = $req->tahun;
        $package->save();


        return response()->json(array(
            'error' => false,
            'message' => "Berhasil menyimpan Data",
            'data' => $package,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function createTestPackageDetail(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
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

        $question_image = '';
        $a_image = '';
        $b_image = '';
        $c_image = '';
        $d_image = '';
        $e_image = '';

        Log::info("answer, masuk bos");
        Log::info($req);
        if (isset($req->question_image)) {
            $imgPath = uploadFile($req->question_image, 'images/soal');
            if ($imgPath) {
                $question_image = $imgPath;
            }
        }
        if (isset($req->a_image)) {
            $imgPath = uploadFile($req->a_image, 'images/soal');
            if ($imgPath) {
                $a_image = $imgPath;
            }
        }
        if (isset($req->b_image)) {
            $imgPath = uploadFile($req->b_image, 'images/soal');
            if ($imgPath) {
                $b_image = $imgPath;
            }
        }
        if (isset($req->c_image)) {
            $imgPath = uploadFile($req->c_image, 'images/soal');
            if ($imgPath) {
                $c_image = $imgPath;
            }
        }
        if (isset($req->d_image)) {
            $imgPath = uploadFile($req->d_image, 'images/soal');
            if ($imgPath) {
                $d_image = $imgPath;
            }
        }
        if (isset($req->e_image)) {
            $imgPath = uploadFile($req->e_image, 'images/soal');
            if ($imgPath) {
                $e_image = $imgPath;
            }
        }
        $package = new soal();
        $package->paket_id = $req->id;
        $package->soal = $req->question;
        $package->jawaban_a = $req->answer_a;
        $package->jawaban_b = $req->answer_b;
        $package->jawaban_c = $req->answer_c;
        $package->jawaban_d = $req->answer_d;
        $package->jawaban_e = $req->answer_e;
        $package->kunci = $req->the_key;
        $package->owner_id = $user->id;


        if ($question_image != '') {

            $package->image_soal = $question_image;
        }
        if ($a_image != '') {

            $package->image_a = $a_image;
        }
        if ($b_image != '') {

            $package->image_b = $b_image;
        }
        if ($c_image != '') {

            $package->image_c = $c_image;
        }
        if ($d_image != '') {

            $package->image_d = $d_image;
        }
        if ($e_image != '') {

            $package->image_e = $e_image;
        }


        $package->save();


        return response()->json(array(
            'error' => false,
            'message' => "Berhasil menyimpan Data",
            'data' => $package,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function deletePackageDetail(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        Log::info("answer, masuk bos");
        Log::info($req);
        $package = soal::where('id', $req->id)->where('owner_id', $user->id)->first();
        $package->is_deleted = 1;;
        $package->save();


        return response()->json(array(
            'error' => false,
            'message' => "Berhasil menghapus soal",
            'data' => $package,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function deletePackage(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }

        $package = PaketSoal::where('id', $req->id)->where('user_id', $user->id)->first();
        $package->is_deleted = 1;;

        $package->save();


        return response()->json(array(
            'error' => false,
            'message' => "Berhasil menghapus Soal",
            'data' => $package,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function shareSoal(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }

        $package = ShareManagerDB::where('user_id', $user->id)->where('package_id', $req->id)->first();

        if (!$package) {
            # code...
            $package = new ShareManagerDB();
            $package->user_id = $user->id;
            $package->package_id = $req->id;
            $token = randomString(48);
            $package->token = $user->id . $req->id . $token;
            $package->end_date =  $req->end_date;
            $package->save();
        }

        return response()->json(array(
            'error' => false,
            'message' => "Berhasil menghapus Soal",
            'data' => $package,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function detailByToken(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        Log::info('detail by token');
        Log::info($req);
        $targetPackage
            = ShareManagerDB::where('token', $req->token)->first();
        if (!$targetPackage) {
            # code...
            return response()->json(array(
                'error' => true,
                'message' => "Soal tidak di temukan",
                'data' => null,
                'status_code' => 200,
                'signature' => null
            ));
        } else {
            # code...
            $package = PaketSoal::where('id', $targetPackage->package_id)->where('is_deleted', 0)->orderBy('id', 'asc')->first();
            $package->tutor_id = $targetPackage->user_id;
    
            return response()->json(array(
                'error' => false,
                'message' => "Berhasil Mengambil Data",
                'data' => $package,
                'status_code' => 200,
                'signature' => null
            ));
        }
        
    }
    public function hasilTestSiswa(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        $packageList
            = AnswerPackages::where('tutor_id', $user->id)->join('users', 'users.id', '=', 'answer_packages.user_id')
            ->select('answer_packages.user_id', DB::raw('COUNT(user_id) as total'), 'users.name', 'users.image', 'users.email', 'users.hp')
            ->groupBy('user_id')->get();


        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $packageList,
            'status_code' => 200,
            'signature' => null
        ));
    }
    public function hasilTestSiswaPackageList(Request $req)
    {

        $user = User::where('remember_token', $req->mobile_token)->first();
        if (!$user) {
            return response()->json(array(
                'error' => true,
                'message' => "Invalid Credential",
                'data' => null,
                'status_code' => 201,
                'signature' => null
            ));
        }
        $answer = AnswerPackages::where('answer_packages.user_id', $req->user_id)->where('tutor_id', $user->id);
        $take = 10;
        $skip = 0;
        if ($req->has('take')) {
            $take = $req->take;
        }
        if ($req->has('skip')) {
            $skip = $req->skip;
        }
        $answer = $answer->join('paket_soals', 'paket_soals.id', '=', 'answer_packages.package_id');
        $answer = $answer->select('paket_soals.*', 'answer_packages.id as test_history_id', 'answer_packages.created_at as test_created_at');
        $answer = $answer->orderBy('id', 'desc')->take($take)->skip($skip)->get();


        return response()->json(array(
            'error' => false,
            'message' => "Berhasil Mengambil Data",
            'data' => $answer,
            'status_code' => 200,
            'signature' => null
        ));
    }
}
