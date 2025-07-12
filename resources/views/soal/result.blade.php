@extends('layouts.app')

@section('content')
<div class="hero-section text-center py-5 mb-4" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/images/hero-bg.jpg'); background-size: cover; background-position: center; color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-md-start">
                <h1 class="display-4 fw-bold mb-3">Kelas Privat</h1>
                <p class="lead mb-4">Tingkatkan kemampuanmu dengan pembelajaran yang lebih personal</p>
            </div>
            <div class="col-md-6 text-center">
                <div class="d-flex justify-content-center gap-4">
                    <div class="icon-box">
                        <i class="fas fa-graduation-cap fa-3x mb-2"></i>
                        <p class="mb-0">Pembelajaran Berkualitas</p>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-book fa-3x mb-2"></i>
                        <p class="mb-0">Materi Terstruktur</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Hasil Test - {{ $paket->nama_paket }}</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2>Nilai Anda</h2>
                        <div class="display-1 text-primary">{{ number_format($score->score, 1) }}</div>
                        <p class="text-muted">Percobaan ke-{{ $score->repeat }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Statistik</h5>
                                    <ul class="list-unstyled">
                                        <li>Total Soal: {{ $questions->count() }}</li>
                                        <li>Jawaban Benar: {{ $answers->where('is_true', 1)->count() }}</li>
                                        <li>Jawaban Salah: {{ $answers->where('is_true', 0)->count() }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Detail Paket</h5>
                                    <ul class="list-unstyled">
                                        <li>Durasi: {{ $paket->durasi }} menit</li>
                                        <li>Jumlah Soal: {{ $paket->jumlah_soal }}</li>
                                        <li>Tanggal Test: {{ $score->created_at->format('d M Y H:i') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Review Jawaban</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Soal</th>
                                        <th>Jawaban Anda</th>
                                        <th>Kunci</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $index => $question)
                                    @php
                                        $answer = $answers->where('id_soal', $question->id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ Str::limit($question->soal, 50) }}</td>
                                        <td>{{ $answer ? $answer->jawaban : '-' }}</td>
                                        <td>{{ $question->kunci }}</td>
                                        <td>
                                            @if($answer && $answer->is_true)
                                                <span class="badge bg-success">Benar</span>
                                            @else
                                                <span class="badge bg-danger">Salah</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('soal.index') }}" class="btn btn-secondary">Kembali ke Daftar Soal</a>
                        <a href="{{ route('soal.show', ['id' => $paket->id, 'index' => 0]) }}" class="btn btn-primary">Coba Lagi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 