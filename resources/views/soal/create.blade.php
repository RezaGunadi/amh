@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Buat Soal Baru">
<meta name="description" content="Buat soal latihan baru untuk SD, SMP, dan SMA dengan mudah dan cepat">
<meta name="keywords" content="Kelas Privat, buat soal, soal online, latihan soal, pembahasan soal">
<meta property="og:title" content="Kelas Privat - Buat Soal Baru">
<meta property="og:description" content="Buat soal latihan baru untuk SD, SMP, dan SMA dengan mudah dan cepat">
<meta property="og:site_name" content="Kelas Privat: Platform Pembelajaran Online">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Buat Soal Baru</h1>
                    <p class="text-muted mb-0">Tambahkan soal latihan untuk paket "{{ $paket->name }}"</p>
                </div>
                <a href="{{ route('paket.edit', $paket->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Form -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('soal.store', $paket->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          id="createSoalForm">
                        @csrf

                        <!-- Question Text -->
                        <div class="mb-4">
                            <label for="soal" class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                            <textarea name="soal" 
                                      id="soal" 
                                      class="form-control @error('soal') is-invalid @enderror" 
                                      rows="4" 
                                      required>{{ old('soal') }}</textarea>
                            @error('soal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Question Image -->
                        <div class="mb-4">
                            <label for="image_soal" class="form-label">Gambar Soal (Opsional)</label>
                            <input type="file" 
                                   name="image_soal" 
                                   id="image_soal" 
                                   class="form-control @error('image_soal') is-invalid @enderror"
                                   accept="image/*">
                            <div class="form-text">
                                Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                            </div>
                            @error('image_soal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" class="mt-3 d-none">
                                <img src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- Answer Options -->
                        <div class="mb-4">
                            <label class="form-label">Pilihan Jawaban <span class="text-danger">*</span></label>
                            @php
                                $options = [
                                    'A' => ['name' => 'jawaban_a', 'image' => 'image_a'],
                                    'B' => ['name' => 'jawaban_b', 'image' => 'image_b'],
                                    'C' => ['name' => 'jawaban_c', 'image' => 'image_c'],
                                    'D' => ['name' => 'jawaban_d', 'image' => 'image_d'],
                                    'E' => ['name' => 'jawaban_e', 'image' => 'image_e']
                                ];
                            @endphp

                            @foreach($options as $key => $option)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="badge bg-primary bg-opacity-10 text-primary me-3">
                                                {{ $key }}
                                            </span>
                                            <div class="flex-grow-1">
                                                <input type="text" 
                                                       name="{{ $option['name'] }}" 
                                                       class="form-control @error($option['name']) is-invalid @enderror"
                                                       placeholder="Masukkan jawaban {{ $key }}"
                                                       value="{{ old($option['name']) }}"
                                                       required>
                                                @error($option['name'])
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="file" 
                                                       name="{{ $option['image'] }}" 
                                                       class="form-control @error($option['image']) is-invalid @enderror"
                                                       accept="image/*">
                                                <div class="form-text">
                                                    Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                                                </div>
                                                @error($option['image'])
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <div id="preview{{ $key }}" class="d-none">
                                                    <img src="" alt="Preview {{ $key }}" class="img-fluid rounded" style="max-height: 100px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Correct Answer -->
                        <div class="mb-4">
                            <label for="kunci_jawaban" class="form-label">Kunci Jawaban <span class="text-danger">*</span></label>
                            <select name="kunci_jawaban" 
                                    id="kunci_jawaban" 
                                    class="form-select @error('kunci_jawaban') is-invalid @enderror"
                                    required>
                                <option value="">Pilih kunci jawaban</option>
                                @foreach($options as $key => $option)
                                    <option value="{{ $key }}" {{ old('kunci_jawaban') == $key ? 'selected' : '' }}>
                                        {{ $key }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kunci_jawaban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Soal
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
.card {
    border: 1px solid rgba(0, 0, 0, 0.125);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.form-control:focus,
.form-select:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.badge {
    font-weight: 500;
    padding: 0.5em 1em;
}

.btn {
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
}

.form-label {
    font-weight: 500;
}

.form-text {
    font-size: 0.875rem;
}

.invalid-feedback {
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview for question
    const imageSoal = document.getElementById('image_soal');
    const imagePreview = document.getElementById('imagePreview');
    
    imageSoal.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.classList.add('d-none');
        }
    });

    // Image preview for answers
    const answerImages = document.querySelectorAll('input[type="file"]');
    answerImages.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                const key = this.name.split('_')[1].toUpperCase();
                const preview = document.getElementById(`preview${key}`);
                
                reader.onload = function(e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    });

    // Form validation
    const form = document.getElementById('createSoalForm');
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // Auto resize textarea
    const textarea = document.getElementById('soal');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endpush

@endsection