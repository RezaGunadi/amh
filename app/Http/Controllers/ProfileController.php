<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', [
            'title' => 'Profile SiLas',
            'user' => $user
        ]);
    }
    public function store(Request $req, $id)
    {
        // $req = $req->toArray();
        // dd($req);
        $data = User::where('id', $req->id)->first();
        if (!empty($req->name)) {
            $data->name=$req->name;
        }
        if (!empty($req->role)) {
            $data->role=$req->role;
        }
        if (!empty($req->sekolah)) {
            $data->sekolah=$req->sekolah;
        }
        if (!empty($req->alamat)) {
            $data->alamat=$req->alamat;
        }
        if (!empty($req->kelas)) {
            $data->kelas=$req->kelas;
        }
        if (!empty($req->hp)) {
            $data->hp=$req->hp;
        }
        if (!empty($req->phone)) {
            $data->phone=$req->phone;
            $data->hp=$req->phone;
        }
        if (!empty($req->point)) {
            $data->point=$req->point;
        }
        if (!empty($req->rating)) {
            $data->rating=$req->rating;
        }
        if (!empty($req->status)) {
            $data->status=$req->status;
        }
        if (!empty($req->image)) {
            # code...
            
            // menyimpan data file yang diupload ke variabel $file
            $originName = $req->file('image')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $req->file('image')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $req->file('image')->move(public_path('upload/image'), $fileName);
   
            $file = $req->file('image');
        

            // isi dengan nama folder tempat kemana file diupload
            // $tujuan_upload = 'data_file';
            $data->image = '/upload/image/'.$fileName;
            // $file->move($tujuan_upload,$file->getClientOriginalName());
        }
        $data->save();
        return redirect()->route('profile');
    }

    public function update(Request $request)
    {
        Log::info('Updating profile');
        Log::info($request->all());
        try {
            $user = Auth::user();
            
            // Validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'school' => 'required|string|max:255',
                'address' => 'required|string',
                'class' => 'required|string|max:50',
                'phone' => 'required|string|max:20',
                'life_motto' => 'nullable|string|max:500',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Update user data
            $user->name = $request->name;
            $user->sekolah = $request->school;
            $user->alamat = $request->address;
            $user->kelas = $request->class;
            $user->hp = $request->phone;
            $user->phone = $request->phone;
            $user->life_motto = $request->life_motto;

            // Handle image upload
            if ($request->hasFile('image')) {
                $originName = $request->file('image')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = $fileName.'_'.time().'.'.$extension;
            
                $request->file('image')->move(public_path('upload/image'), $fileName);
                $user->image = '/upload/image/'.$fileName;
            }

            // Save changes
            $saved = $user->save();
            if (!$saved) {
                throw new \Exception('Gagal menyimpan perubahan');
            }

            Log::info('Profile updated successfully');
            Log::info('Updated user data:', $user->toArray());

            return redirect()->route('my_profile')->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->route('my_profile')->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

}
