<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:owner');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::active()->get();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|in:tips-belajar,pendidikan,teknologi,motivasi,karir,komunitas',
            'author_name' => 'required|string|max:255',
            'reading_time' => 'required|integer|min:1|max:60',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'svg_icon' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_published' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        if ($request->is_published) {
            $data['published_at'] = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog/images', 'public');
            $data['featured_image'] = $path;
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blog)
    {
        return view('admin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::active()->get();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|in:tips-belajar,pendidikan,teknologi,motivasi,karir,komunitas',
            'author_name' => 'required|string|max:255',
            'reading_time' => 'required|integer|min:1|max:60',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'svg_icon' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_published' => 'boolean'
        ]);

        $data = $request->all();
        
        // Update slug if title changed
        if ($request->title !== $blog->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // Handle published status
        if ($request->is_published && !$blog->is_published) {
            $data['published_at'] = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            
            $path = $request->file('featured_image')->store('blog/images', 'public');
            $data['featured_image'] = $path;
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blog)
    {
        // Delete featured image
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(BlogPost $blog)
    {
        $blog->update(['is_featured' => !$blog->is_featured]);
        
        $status = $blog->is_featured ? 'ditampilkan' : 'disembunyikan';
        return redirect()->back()->with('success', "Artikel berhasil {$status} dari unggulan!");
    }

    /**
     * Toggle published status
     */
    public function togglePublished(BlogPost $blog)
    {
        $data = ['is_published' => !$blog->is_published];
        
        if (!$blog->is_published) {
            $data['published_at'] = now();
        }

        $blog->update($data);
        
        $status = $blog->is_published ? 'dipublikasikan' : 'disimpan sebagai draft';
        return redirect()->back()->with('success', "Artikel berhasil {$status}!");
    }
}
