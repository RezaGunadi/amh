@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Profil Pengguna">
<meta name="description" content="Kelola profil pengguna Kelas Privat. Update informasi pribadi, foto profil, dan preferensi belajar Anda.">
<meta name="keywords" content="Kelas Privat, Profil pengguna, Update profil, Foto profil, Preferensi belajar, Bimbel online, Les privat online">
<meta property="og:title" content="Kelas Privat - Profil Pengguna">
<meta property="og:description" content="Kelola profil pengguna Kelas Privat. Update informasi pribadi, foto profil, dan preferensi belajar Anda.">
<meta property="og:site_name" content="Kelas Privat: Profil Pengguna">
<meta property="og:image" content="https://kelas-privat.com/assets/img/logo.png">
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="600">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="robots" content="index, follow">
<meta name="language" content="Indonesian">
<meta name="revisit-after" content="7 days">
<meta name="author" content="Kelas Privat">
@endpush

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil Pengguna</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" data-aos="fade-up">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 mb-4 text-center">Profil Pengguna</h1>

                    <form action="{{ route('update_my_profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Profile Image -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="{{ $user->image ? URL::To($user->image) : asset('assets/img/default-avatar.svg') }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle mb-3"
                                     style="width: 150px; height: 150px; object-fit: cover;"
                                     id="preview-image">
                                <label for="image" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 cursor-pointer">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" name="image" id="image" class="d-none" accept="image/*">
                            </div>
                            <p class="text-muted small">Klik ikon kamera untuk mengubah foto profil</p>
                        </div>

                        <!-- User Information -->
                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           placeholder="Nama Lengkap"
                                           value="{{ old('name', $user->name) }}"
                                           required>
                                    <label for="name">Nama Lengkap</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- School -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('school') is-invalid @enderror" 
                                           id="school" 
                                           name="school" 
                                           placeholder="Sekolah"
                                           value="{{ old('school', $user->sekolah) }}"
                                           required>
                                    <label for="school">Sekolah</label>
                                    @error('school')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" 
                                              name="address" 
                                              placeholder="Alamat"
                                              style="height: 100px"
                                              required>{{ old('address', $user->alamat) }}</textarea>
                                    <label for="address">Alamat</label>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Class -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('class') is-invalid @enderror" 
                                           id="class" 
                                           name="class" 
                                           placeholder="Kelas"
                                           value="{{ old('class', $user->kelas) }}"
                                           required>
                                    <label for="class">Kelas</label>
                                    @error('class')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           placeholder="Nomor HP"
                                           value="{{ old('phone', $user->hp) }}"
                                           required>
                                    <label for="phone">Nomor HP</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Life Motto -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('life_motto') is-invalid @enderror" 
                                              id="life_motto" 
                                              name="life_motto" 
                                              placeholder="Motto Hidup"
                                              style="height: 100px">{{ old('life_motto', $user->life_motto) }}</textarea>
                                    <label for="life_motto">Motto Hidup</label>
                                    @error('life_motto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Stats Section -->
                        <div class="row g-4 mt-4">
                            <div class="col-md-6">
                                <div class="card border-0 bg-primary bg-opacity-10 h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                                    <i class="fas fa-star text-primary fa-2x"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="text-muted mb-1">Poin</h6>
                                                <h3 class="mb-0">{{ $user->points ?? 0 }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-success bg-opacity-10 h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                                    <i class="fas fa-chart-line text-success fa-2x"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="text-muted mb-1">Rating</h6>
                                                <h3 class="mb-0">{{ $user->rating ?? 0 }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: #0d6efd;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.cursor-pointer {
    cursor: pointer;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true
    });

    // Image Preview
    const imageInput = document.getElementById('image');
    const previewImage = document.getElementById('preview-image');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Image Error Handler
    previewImage.addEventListener('error', function() {
        this.src = '{{ asset("assets/img/default-avatar.png") }}';
    });
});
</script>
@endpush
@endsection