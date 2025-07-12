@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Edit Paket Soal">
<meta name="description" content="Edit paket soal latihan untuk siswa SD, SMP, dan SMA">
<meta name="keywords" content="Kelas Privat, edit paket soal, soal latihan, soal SD, soal SMP, soal SMA">
<meta property="og:title" content="Kelas Privat - Edit Paket Soal">
<meta property="og:description" content="Edit paket soal latihan untuk siswa SD, SMP, dan SMA">
<meta property="og:site_name" content="Kelas Privat: Platform Pembelajaran Online">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">{{ $paket->name }}</h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('create_soal', $paket->id) }}" class="btn btn-success">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Soal
                    </a>
                    <a href="{{ route('change_public_paket', $paket->id) }}" 
                       class="btn {{ $paket->is_public ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $paket->is_public ? 'Public' : 'Private' }}
                    </a>
                </div>
            </div>

            <!-- Questions List -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    @if (!empty($soal))
                        @foreach ($soal as $index => $item)
                            <div class="question-item mb-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary me-3">
                                            Soal {{ $index + 1 }}
                                        </span>
                                        <h3 class="h5 mb-0">{{ Str::limit($item->soal, 100) }}</h3>
                                    </div>
                                    <a href="{{ route('delete_soal', $item->id) }}" 
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>

                                @if ($item->image_soal)
                                    <div class="mb-3">
                                        <img src="{{ URL::To($item->image_soal) }}" 
                                             alt="Gambar Soal" 
                                             class="img-fluid rounded"
                                             style="max-height: 200px;">
                                    </div>
                                @endif

                                <div class="row g-3">
                                    @php
                                        $options = [
                                            'A' => ['text' => $item->jawaban_a, 'image' => $item->image_a],
                                            'B' => ['text' => $item->jawaban_b, 'image' => $item->image_b],
                                            'C' => ['text' => $item->jawaban_c, 'image' => $item->image_c],
                                            'D' => ['text' => $item->jawaban_d, 'image' => $item->image_d],
                                            'E' => ['text' => $item->jawaban_e, 'image' => $item->image_e]
                                        ];
                                    @endphp

                                    @foreach($options as $key => $option)
                                        <div class="col-md-6">
                                            <div class="card h-100 {{ $key === $item->kunci ? 'border-success' : '' }}">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="badge {{ $key === $item->kunci ? 'bg-success' : 'bg-secondary' }} me-2">
                                                            {{ $key }}
                                                        </span>
                                                        <span class="text-muted">{{ $option['text'] }}</span>
                                                    </div>
                                                    @if($option['image'])
                                                        <img src="{{ URL::To($option['image']) }}" 
                                                             alt="Gambar Jawaban" 
                                                             class="img-fluid rounded"
                                                             style="max-height: 100px;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h3 class="h5 text-muted">Belum ada soal</h3>
                            <p class="text-muted">Tambahkan soal baru untuk paket ini</p>
                            <a href="{{ route('create_soal', $paket->id) }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Soal
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.question-item {
    transition: all 0.3s ease;
}

.question-item:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endpush

@endsection