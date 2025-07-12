@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Buat Diskusi Baru">
<meta name="description" content="Buat diskusi baru di forum Kelas Privat. Berbagi pertanyaan, pengalaman, dan pengetahuan dengan komunitas belajar online.">
<meta name="keywords" content="Kelas Privat, forum diskusi, diskusi online, tanya jawab online, komunitas belajar">
<meta property="og:title" content="Kelas Privat - Buat Diskusi Baru">
<meta property="og:description" content="Buat diskusi baru di forum Kelas Privat. Berbagi pertanyaan, pengalaman, dan pengetahuan dengan komunitas belajar online.">
<meta property="og:site_name" content="Kelas Privat: Forum Diskusi Online">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h1 class="h4 mb-0">Buat Diskusi Baru</h1>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('chat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="form-label">Judul Diskusi</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   placeholder="Masukkan judul diskusi"
                                   value="{{ old('title') }}"
                                   required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="chat" class="form-label">Isi Diskusi</label>
                            <textarea class="form-control @error('chat') is-invalid @enderror" 
                                      id="chat" 
                                      name="chat" 
                                      rows="10" 
                                      placeholder="Tulis isi diskusi Anda di sini..."
                                      required>{{ old('chat') }}</textarea>
                            @error('chat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="picture" class="form-label">Gambar (Opsional)</label>
                            <input type="file" 
                                   class="form-control @error('picture') is-invalid @enderror" 
                                   id="picture" 
                                   name="picture"
                                   accept="image/*">
                            <div class="form-text">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</div>
                            @error('picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('chat.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Diskusi
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
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview image before upload
    const pictureInput = document.getElementById('picture');
    const picturePreview = document.createElement('img');
    picturePreview.className = 'img-fluid mt-2 rounded';
    picturePreview.style.maxHeight = '200px';
    picturePreview.style.display = 'none';
    
    pictureInput.parentNode.appendChild(picturePreview);
    
    pictureInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                picturePreview.src = e.target.result;
                picturePreview.style.display = 'block';
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            picturePreview.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection