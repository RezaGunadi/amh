@extends('layouts.public')

@section('title', 'Halaman Tidak Ditemukan — amhriset.com')
@section('description', 'Halaman yang Anda cari tidak ditemukan. Jelajahi produk amhriset atau kembali ke beranda.')

@section('content')

    <section class="section" style="min-height:60vh;display:grid;place-items:center">
        <div class="container container-narrow center">
            <div class="tabular"
                style="font-size:clamp(4.5rem,3rem+9vw,9rem);font-weight:800;line-height:1;letter-spacing:-.06em;background:linear-gradient(135deg,var(--brand),#a855f7);-webkit-background-clip:text;background-clip:text;color:transparent">
                404
            </div>

            <h1 class="mt-3" style="font-size:clamp(1.6rem,1.2rem+1.8vw,2.4rem)">Halaman tidak ditemukan</h1>
            <p class="lead mt-3">
                Alamat yang Anda buka mungkin sudah dipindahkan, dihapus, atau tidak pernah ada. Mari kembali ke jalur
                yang benar.
            </p>

            <div class="hero-actions" style="justify-content:center">
                <a class="btn btn-primary btn-lg" href="{{ url('/') }}">Kembali ke Beranda</a>
                <a class="btn btn-secondary btn-lg" href="{{ url('/#produk') }}">Lihat Produk</a>
            </div>
        </div>
    </section>

    <section class="section-tight section-subtle" style="border-top:1px solid var(--border)">
        <div class="container">
            <div class="section-head center" style="margin-bottom:32px">
                <h2 style="font-size:1.4rem">Mungkin Anda mencari ini</h2>
            </div>

            <div class="grid grid-3">
                <a class="card card-hover card-accent" href="{{ url('/child-care') }}"
                    style="--accent:var(--childcare);--accent-soft:var(--childcare-soft)">
                    <div class="card-icon" aria-hidden="true">👟</div>
                    <h3>Child Care</h3>
                    <p>Smart shoe monitoring untuk memantau kesehatan dan lokasi anak secara real-time.</p>
                </a>

                <a class="card card-hover card-accent" href="{{ url('/sipintar') }}"
                    style="--accent:var(--sipintar);--accent-soft:var(--sipintar-soft)">
                    <div class="card-icon" aria-hidden="true">🥗</div>
                    <h3>Sipintar</h3>
                    <p>Platform edukasi nutrisi interaktif dengan tracking konsumsi dan gamifikasi.</p>
                </a>

                <a class="card card-hover card-accent" href="mailto:contact@amhriset.com">
                    <div class="card-icon" aria-hidden="true">✉️</div>
                    <h3>Hubungi Kami</h3>
                    <p>Tidak menemukan yang Anda cari? Kirim pesan dan tim kami akan membantu.</p>
                </a>
            </div>
        </div>
    </section>

@endsection
