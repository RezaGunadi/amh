@extends('layouts.app')

@section('title', 'Kelola Blog - Admin Panel')
@section('meta_description', 'Panel admin untuk mengelola artikel blog KelasPrivat.id')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Kelola Artikel Blog</h5>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Artikel
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Status</th>
                                    <th>Unggulan</th>
                                    <th>Views</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                                     alt="{{ $post->title }}" 
                                                     class="rounded me-3" 
                                                     width="50" height="50" 
                                                     style="object-fit: cover;">
                                            @elseif($post->svg_icon)
                                                <img src="{{ asset($post->svg_icon) }}" 
                                                     alt="{{ $post->title }}" 
                                                     class="rounded me-3" 
                                                     width="50" height="50">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $post->title }}</h6>
                                                <small class="text-muted">{{ Str::limit($post->excerpt, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $post->category_badge_color }}">
                                            {{ $post->category_display_name }}
                                        </span>
                                    </td>
                                    <td>{{ $post->author_name }}</td>
                                    <td>
                                        @if($post->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post->is_featured)
                                            <span class="badge bg-primary">Featured</span>
                                        @else
                                            <span class="badge bg-secondary">Regular</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($post->views) }}</td>
                                    <td>{{ $post->published_at ? $post->published_at->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.blog.show', $post) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.blog.edit', $post) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.blog.destroy', $post) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <div class="btn-group mt-1" role="group">
                                            <form action="{{ route('admin.blog.toggle-featured', $post) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-{{ $post->is_featured ? 'secondary' : 'primary' }}" 
                                                        title="{{ $post->is_featured ? 'Hapus dari unggulan' : 'Jadikan unggulan' }}">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.blog.toggle-published', $post) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-{{ $post->is_published ? 'warning' : 'success' }}" 
                                                        title="{{ $post->is_published ? 'Simpan sebagai draft' : 'Publish' }}">
                                                    <i class="fas fa-{{ $post->is_published ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group .btn {
    margin-right: 2px;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endsection 