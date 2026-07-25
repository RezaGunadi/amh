@extends('layouts.public')

@section('title', 'Terjadi Kesalahan Server — amhriset.com')
@section('description', 'Terjadi kesalahan pada server kami. Tim kami sudah diberi tahu — silakan coba beberapa saat lagi.')

@section('content')

    <section class="section" style="min-height:60vh;display:grid;place-items:center">
        <div class="container container-narrow center">
            <div class="tabular"
                style="font-size:clamp(4.5rem,3rem+9vw,9rem);font-weight:800;line-height:1;letter-spacing:-.06em;background:linear-gradient(135deg,var(--danger),#f59e0b);-webkit-background-clip:text;background-clip:text;color:transparent">
                500
            </div>

            <h1 class="mt-3" style="font-size:clamp(1.6rem,1.2rem+1.8vw,2.4rem)">Terjadi kesalahan di sisi kami</h1>
            <p class="lead mt-3">
                Ini bukan kesalahan Anda. Server kami mengalami kendala saat memproses permintaan ini — tim kami sudah
                diberi tahu dan sedang menanganinya.
            </p>

            <div class="hero-actions" style="justify-content:center">
                <a class="btn btn-primary btn-lg" href="{{ url()->current() }}">Coba Lagi</a>
                <a class="btn btn-secondary btn-lg" href="{{ url('/') }}">Kembali ke Beranda</a>
            </div>

            <div class="note mt-6" style="text-align:left">
                <span class="note-icon" aria-hidden="true">🛠️</span>
                <span>
                    <strong>Masih bermasalah?</strong>
                    Jika kesalahan ini terus muncul, beri tahu kami di
                    <a href="mailto:support@amhriset.com">support@amhriset.com</a> beserta alamat halaman yang Anda buka.
                </span>
            </div>
        </div>
    </section>

@endsection
