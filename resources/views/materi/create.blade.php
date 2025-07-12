@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Tambah Materi Baru">
<meta name="description" content="Tambah materi pembelajaran baru di Kelas Privat. Berbagi pengetahuan dan membantu sesama dalam belajar.">
<meta name="keywords" content="Kelas Privat, tambah materi, materi pembelajaran, berbagi pengetahuan, belajar online">
<meta property="og:title" content="Kelas Privat - Tambah Materi Baru">
<meta property="og:description" content="Tambah materi pembelajaran baru di Kelas Privat. Berbagi pengetahuan dan membantu sesama dalam belajar.">
<meta property="og:site_name" content="Kelas Privat: Platform Pembelajaran Online">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h1 class="h4 mb-0">Tambah Materi Baru</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="form-label">Judul Materi</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   placeholder="Masukkan judul materi"
                                   value="{{ old('title') }}"
                                   required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" 
                                    name="category"
                                    required>
                                <option value="">Pilih kategori</option>
                                <option value="SD" {{ old('category') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('category') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('category') == 'SMA' ? 'selected' : '' }}>SMA</option>
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="subject" class="form-label">Mata Pelajaran</label>
                            <select class="form-select @error('subject') is-invalid @enderror" 
                                    id="subject" 
                                    name="subject"
                                    required>
                                <option value="">Pilih mata pelajaran</option>
                                <option value="Matematika" {{ old('subject') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                                <option value="Bahasa Indonesia" {{ old('subject') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                <option value="Bahasa Inggris" {{ old('subject') == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                                <option value="IPA" {{ old('subject') == 'IPA' ? 'selected' : '' }}>IPA</option>
                                <option value="IPS" {{ old('subject') == 'IPS' ? 'selected' : '' }}>IPS</option>
                            </select>
                            @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label">Isi Materi</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="15" 
                                      placeholder="Tulis isi materi Anda di sini..."
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Gambar Materi (Opsional)</label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image"
                                   accept="image/*">
                            <div class="form-text">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</div>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('materi.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Materi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview image before upload
    const imageInput = document.getElementById('image');
    const imagePreview = document.createElement('img');
    imagePreview.className = 'img-fluid mt-2 rounded';
    imagePreview.style.maxHeight = '200px';
    imagePreview.style.display = 'none';
    
    imageInput.parentNode.appendChild(imagePreview);
    
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            imagePreview.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection