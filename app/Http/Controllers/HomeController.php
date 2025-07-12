<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\news;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home.index',[
            'title' => 'Kelas Privat',
        ]);
    }
    public function index()
    {
        $data = \Illuminate\Support\Facades\DB::table('news')->orderBy('id','desc')->get();
        foreach ($data as $value) {
            # code...
            $value->images = Image::where('news_id', $value->id)->orderBy('id','desc')->get();
        }
        return view('news',[
            'title' => 'Kelas News',
            'data' => $data,
        ]);
    }
    public function create()
    {
        return view('home.create',[
            'title' => 'Kelas News',
            'type' => 'news',
        ]);
    }
    public function store(Request $request){
        // $request = $request->toArray();
        // dd($request);
    //   $this->validate($request, [
    //      'name' => 'required|string|max:255',
    //      'description' => 'required|string|max:855',
    //     ]);
        $news = new news();
        $news->title = $request->title;
        $news->category = $request->category;
        $news->description = $request->description;
        $news->created_by = $request->created_by;
        $news->user_id = $request->created_by;
        $news->save();
        if ($request->file('images')) {
            // dd($request->file('images'));
            # code...
            foreach ($request->file('images') as $imagefile) {
                $image = new Image();
                // $path = $imagefile->store('/images/resource', ['disk' =>   'my_files']);
                
                // menyimpan data file yang diupload ke variabel $file
                $originName = $imagefile->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $imagefile->getClientOriginalExtension();
                $fileName = $fileName.'_'.time().'.'.$extension;
                $imagefile->move(public_path('upload/image'), $fileName);
    
                $file = $imagefile;
            

                // isi dengan nama folder tempat kemana file diupload
                // $tujuan_upload = 'data_file';
                $image->url = '/upload/image/'.$fileName;
                // $file->move($tujuan_upload,$file->getClientOriginalName());
            
                // $image->url = $path;
                $image->news_id = $news->id;
                $image->save();
            }
        }
        return redirect()->back()->with('success', 'posting telah berhasil di buat');
    }
}
