<?php

namespace App\Http\Controllers;

use App\Models\soal;
use App\Models\jawaban;
use App\Models\PaketSoal;
use App\Models\ScoreJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
    //
    
    public function index(Request $request)
    {
        $paket = PaketSoal::where('is_deleted', 0);
        $role = 'null';
        
        // Filter by jenjang if provided
        if ($request->has('jenjang')) {
            $paket = $paket->where('jenjang', $request->jenjang);
        }
        
        if (empty(Auth::user())) {
            $paket = $paket->where('user_id', 1);
        } else {
            $role = Auth::user()->role;
            if (Auth::user()->role == 'ADMIN') {
                // Admin can see all questions
            } else if (Auth::user()->role == 'SISWA') {
                $paket = $paket->where('is_public', 1);
            } else {
                $paket = $paket->where(function ($query) {
                    $query->where('user_id', Auth::user()->role)
                          ->orWhere('user_id', 1);
                });
            }
        }
        
        // Use paginate instead of get
        $paket = $paket->orderBy('id', 'desc')->paginate(12);
        
        // Calculate total soal for each paket
        $totalSoal = [];
        foreach ($paket as $p) {
            $totalSoal[$p->id] = (string) soal::where('paket_id', $p->id)
                                    ->where('is_deleted', 0)
                                    ->count();
        }
        
        // Get list of unique subjects for filter
        $mapelList = PaketSoal::where('is_deleted', 0)
                             ->distinct()
                             ->pluck('mapel')
                             ->filter()
                             ->values()
                             ->toArray();
        
        return view('soal.index', [
            'title' => 'Latihan Soal SiLas',
            'paket' => $paket,
            'role' => $role,
            'jenjang' => $request->jenjang ?? null,
            'totalSoal' => $totalSoal,
            'mapelList' => $mapelList
        ]);
    }

    public function delete($soal_id)
    {
        # code...
        $soal = soal::where('id', $soal_id)->where('owner_id', Auth::user()->id)->where('is_deleted', 0)->first();
        if (!$soal) {
            # code...
            return redirect()->back()->with('error', 'Soal Tidak tersedia, harap menghubungi admin');
        }
        $soal->is_deleted = 1;
        $soal->save();
        return redirect()->back()->with('success', 'Soal berhasil dihapus');

    }
    public function show(Request $req)
    {
        $soal = soal::where('paket_id', $req->paket)
                    ->where('is_deleted', 0)
                    ->get();
                    
        $paket = PaketSoal::where('id', $req->paket)
                          ->where('is_deleted', 0)
                          ->first();
                          
        if (!$paket) {
            return redirect()->route('soal.index')
                            ->with('error', 'Paket soal tidak ditemukan');
        }

        // Get current question index from request or default to 0
        $currentIndex = $req->index ?? 0;
        
        // Get current question
        $currentSoal = $soal->get($currentIndex);
        
        if (!$currentSoal) {
            return redirect()->route('soal.index')
                            ->with('error', 'Soal tidak ditemukan');
        }

        // Initialize arrays for answers and flags
        $answers = array_fill(0, $soal->count(), null);
        $flagged = array_fill(0, $soal->count(), false);
        
        // Get temporary answers from session if they exist
        $sessionKey = 'temp_answers_' . $paket->id;
        $sessionFlaggedKey = 'temp_flagged_' . $paket->id;
        
        if (session()->has($sessionKey)) {
            $answers = session($sessionKey);
        }
        if (session()->has($sessionFlaggedKey)) {
            $flagged = session($sessionFlaggedKey);
        }
        
        return view('soal.show', [
            'title' => 'Latihan Soal SiLas',
            'soal' => $currentSoal,
            'allSoal' => $soal,
            'paket' => $paket,
            'currentIndex' => $currentIndex,
            'answers' => $answers,
            'flagged' => $flagged
        ]);
    }
    public function list()
    {
        // $req = $req->toArray();
        // dd($req);
        $paket = PaketSoal::where('user_id', Auth::user()->id)->where('is_deleted', 0)
        // ->orderBy('id','desc')
        ->get();
        return view('paket.list',[
            'title' => 'List Soal',
            'paket' => $paket,
        ]);
    }
    public function create(Request $req, $paket_id)
    {
        return view('soal.create',[
            'title' => 'Buat Soal',
            'paket' => $paket_id
        ]);
    }
    public function store(Request $req)
    {
        // $req = $req->toArray();
        // dd($req);
        $soal = new soal();
        $soal->soal = $req->soal;	
        $soal->jawaban_a = $req->jawaban_a;	
        $soal->jawaban_b = $req->jawaban_b;	
        $soal->jawaban_c = $req->jawaban_c;	
        $soal->jawaban_d = $req->jawaban_d;	
        $soal->jawaban_e = $req->jawaban_e;	
        $soal->kunci = $req->kunci;	
        // $soal->grade = $req->tingkat;	
        // $soal->kelas = 3;	
        // $soal->mapel = $req->mapel;	
        $soal->paket_id = $req->paket_id;	
        $soal->owner_id = Auth::user()->id;	
        if (!empty($req->image_soal)) {
            # code...
            
            // menyimpan data file yang diupload ke variabel $file
            $originName = $req->file('image_soal')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $req->file('image_soal')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $req->file('image_soal')->move(public_path('upload/image'), $fileName);
   
            $file = $req->file('image_soal');
        

            // isi dengan nama folder tempat kemana file diupload
            // $tujuan_upload = 'data_file';
            $soal->image_soal = '/upload/image/'.$fileName;
            // $file->move($tujuan_upload,$file->getClientOriginalName());
        }
        if (!empty($req->image_a)) {
            # code...
            
            // menyimpan data file yang diupload ke variabel $file
            $originName = $req->file('image_a')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $req->file('image_a')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $req->file('image_a')->move(public_path('upload/image'), $fileName);
   
            $file = $req->file('image_a');
        

            // isi dengan nama folder tempat kemana file diupload
            // $tujuan_upload = 'data_file';
            $soal->image_a = '/upload/image/'.$fileName;
            // $file->move($tujuan_upload,$file->getClientOriginalName());
        }
        if (!empty($req->image_b)) {
            # code...
            
            // menyimpan data file yang diupload ke variabel $file
            $originName = $req->file('image_b')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $req->file('image_b')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $req->file('image_b')->move(public_path('upload/image'), $fileName);
   
            $file = $req->file('image_b');
        

            // isi dengan nama folder tempat kemana file diupload
            // $tujuan_upload = 'data_file';
            $soal->image_b = '/upload/image/'.$fileName;
            // $file->move($tujuan_upload,$file->getClientOriginalName());
        }
        if (!empty($req->image_c)) {
            # code...
            
            // menyimpan data file yang diupload ke variabel $file
            $originName = $req->file('image_c')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $req->file('image_c')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $req->file('image_c')->move(public_path('upload/image'), $fileName);
   
            $file = $req->file('image_c');
        

            // isi dengan nama folder tempat kemana file diupload
            // $tujuan_upload = 'data_file';
            $soal->image_c = '/upload/image/'.$fileName;
            // $file->move($tujuan_upload,$file->getClientOriginalName());
        }
        if (!empty($req->image_d)) {
            # code...
            
            // menyimpan data file yang diupload ke variabel $file
            $originName = $req->file('image_d')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $req->file('image_d')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $req->file('image_d')->move(public_path('upload/image'), $fileName);
   
            $file = $req->file('image_d');
        

            // isi dengan nama folder tempat kemana file diupload
            // $tujuan_upload = 'data_file';
            $soal->image_d = '/upload/image/'.$fileName;
            // $file->move($tujuan_upload,$file->getClientOriginalName());
        }
        if (!empty($req->image_e)) {
            # code...
            
            // menyimpan data file yang diupload ke variabel $file
            $originName = $req->file('image_e')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $req->file('image_e')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $req->file('image_e')->move(public_path('upload/image'), $fileName);
   
            $file = $req->file('image_e');
        

            // isi dengan nama folder tempat kemana file diupload
            // $tujuan_upload = 'data_file';
            $soal->image_e = '/upload/image/'.$fileName;
            // $file->move($tujuan_upload,$file->getClientOriginalName());
        }
        $soal->save();
        
        return redirect()->back()->with('success', 'Soal berhasil dibuat');
        // return view('soal.create',[
        //     'title' => 'Buat Soal'
        // ]);
    }
    public function showHasil(Request $request, $id, $index)
    {
        try {
            // Validate request
            if (!Auth::check()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Anda harus login terlebih dahulu',
                    'redirect' => route('login')
                ], 401);
            }

            $paket = PaketSoal::where('id', $id)
                             ->where('is_deleted', 0)
                             ->first();
                             
            if (!$paket) {
                return response()->json([
                    'error' => true,
                    'message' => 'Paket soal tidak ditemukan'
                ], 404);
            }
                             
            $soal = soal::where('paket_id', $id)
                        ->where('is_deleted', 0)
                        ->orderBy('id', 'asc')
                        ->get();
                        
            if (!$soal->count()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Tidak ada soal yang tersedia'
                ], 404);
            }

            // Get answers from request
            $answers = $request->input('answers', []);
            $flagged = $request->input('flagged', []);
            
            // Start database transaction
            DB::beginTransaction();
            
            try {
                // Save answers to database
                foreach ($answers as $soalIndex => $answer) {
                    if ($answer) {
                        // Validate answer format
                        if (!in_array(strtoupper($answer), ['A', 'B', 'C', 'D', 'E'])) {
                            throw new \Exception('Format jawaban tidak valid');
                        }
                        
                        $currentSoal = $soal->get($soalIndex);
                        if ($currentSoal) {
                            // Create new answer
                            $newAnswer = new jawaban();
                            $newAnswer->user_id = Auth::id();
                            $newAnswer->id_soal = $currentSoal->id;
                            $newAnswer->id_paket = $paket->id;
                            $newAnswer->kunci = $currentSoal->kunci;
                            $newAnswer->jawaban = $answer;
                            $newAnswer->is_true = strtolower($answer) === strtolower($currentSoal->kunci) ? 1 : 0;
                            $newAnswer->save();
                        }
                    }
                }

                // Calculate score
                $totalQuestions = $soal->count();
                $correctAnswers = jawaban::where('user_id', Auth::id())
                                       ->where('id_paket', $paket->id)
                                       ->where('is_true', 1)
                                       ->count();
                                       
                $score = ($correctAnswers / $totalQuestions) * 100;
                
                // Get latest repeat count with lock to prevent race condition
                $latestScore = ScoreJawaban::where('user_id', Auth::id())
                                         ->where('paket_id', $paket->id)
                                         ->lockForUpdate()
                                         ->latest('id')
                                         ->first();
                                         
                $repeat = $latestScore ? $latestScore->repeat + 1 : 1;
                
                // Save score
                $scoreJawaban = new ScoreJawaban();
                $scoreJawaban->paket_id = $paket->id;
                $scoreJawaban->user_id = Auth::id();
                $scoreJawaban->score = $score;
                $scoreJawaban->repeat = $repeat;
                $scoreJawaban->save();

                // Clear temporary answers from session
                session()->forget('temp_answers_' . $paket->id);
                session()->forget('temp_flagged_' . $paket->id);

                // Commit transaction
                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => 'Jawaban berhasil disimpan',
                    'redirect' => route('soal.result', ['id' => $paket->id])
                ]);
                
            } catch (\Exception $e) {
                // Rollback transaction on error
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            \Log::error('Error in showHasil: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan saat menyimpan jawaban: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showResult($id)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $paket = PaketSoal::where('id', $id)
                             ->where('is_deleted', 0)
                             ->first();
                             
            if (!$paket) {
                return redirect()->route('soal.index')
                                ->with('error', 'Paket soal tidak ditemukan');
            }

            // Get latest score
            $score = ScoreJawaban::where('user_id', Auth::id())
                                ->where('paket_id', $id)
                                ->latest('id')
                                ->first();
                                
            if (!$score) {
                return redirect()->route('soal.index')
                                ->with('error', 'Hasil test tidak ditemukan');
            }

            // Get all answers
            $answers = jawaban::where('user_id', Auth::id())
                            ->where('id_paket', $id)
                            ->get();

            // Get all questions
            $questions = soal::where('paket_id', $id)
                           ->where('is_deleted', 0)
                           ->orderBy('id', 'asc')
                           ->get();

            return view('soal.result', [
                'title' => 'Hasil Test',
                'paket' => $paket,
                'score' => $score,
                'answers' => $answers,
                'questions' => $questions
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in showResult: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->route('soal.index')
                            ->with('error', 'Terjadi kesalahan saat menampilkan hasil test');
        }
    }

    public function saveTempAnswers(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Anda harus login terlebih dahulu'
                ], 401);
            }

            $paket = PaketSoal::where('id', $id)
                             ->where('is_deleted', 0)
                             ->first();
                             
            if (!$paket) {
                return response()->json([
                    'error' => true,
                    'message' => 'Paket soal tidak ditemukan'
                ], 404);
            }

            // Save answers to session
            session(['temp_answers_' . $id => $request->input('answers', [])]);
            session(['temp_flagged_' . $id => $request->input('flagged', [])]);

            return response()->json([
                'error' => false,
                'message' => 'Jawaban sementara berhasil disimpan'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in saveTempAnswers: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan saat menyimpan jawaban sementara'
            ], 500);
        }
    }
}
