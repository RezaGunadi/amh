@extends('layouts.public')

@section('title', $title ?? 'Sipintar — Edukasi Nutrisi Interaktif')
@section('description', 'Sipintar: aplikasi edukasi nutrisi dengan database jajanan lengkap, tracking konsumsi harian, favorites, dan gamifikasi untuk membangun budaya jajanan sehat.')

@section('nav_links')
    <a href="#fitur">Fitur</a>
    <a href="#cara-kerja">Cara Kerja</a>
    <a href="#sekolah">Untuk Sekolah</a>
    <a href="#download">Download</a>
@endsection

@section('nav_actions')
    <a class="btn btn-primary btn-sm" href="#download">Download Gratis</a>
@endsection

@section('content')

    {{-- ─────────────────────────────────────────────────────────── HERO ── --}}
    <section class="hero on-ink" style="--brand:var(--sipintar)">
        <div class="container">
            <div class="hero-split">
                <div>
                    <span class="chip chip-ink chip-dot">Edukasi • Gamifikasi</span>

                    <h1 class="mt-3">Belajar nutrisi jadi menyenangkan, bukan menggurui</h1>

                    <p class="lead">
                        Sipintar membantu siswa memahami kandungan gizi jajanan sehari-hari lewat database lengkap,
                        tracking konsumsi, dan sistem gamifikasi yang bikin ketagihan belajar.
                    </p>

                    <div class="hero-actions">
                        <a class="btn btn-primary btn-lg" href="#download">Download Sekarang</a>
                        <a class="btn btn-secondary btn-lg" href="#fitur">Pelajari Fitur</a>
                    </div>

                    <div class="hero-chips">
                        <span class="chip chip-ink">Gratis</span>
                        <span class="chip chip-ink">Tanpa iklan</span>
                        <span class="chip chip-ink">Browsing tanpa login</span>
                    </div>
                </div>

                {{-- Menu card mock --}}
                <div class="card reveal"
                    style="background:rgba(255,255,255,.05);border-color:rgba(255,255,255,.13);backdrop-filter:blur(14px)">
                    <div class="row" style="justify-content:space-between">
                        <div>
                            <div class="small" style="color:var(--ink-muted)">Menu hari ini</div>
                            <strong style="color:#fff;font-size:1.05rem">Bakwan Sayur</strong>
                        </div>
                        <span class="chip chip-ink" style="color:#fcd34d">Sedang</span>
                    </div>

                    <div class="grid grid-2 mt-4" style="gap:12px">
                        @foreach ([['Kalori', '137', 'kkal'], ['Protein', '2.4', 'g'], ['Lemak', '8.1', 'g'], ['Karbohidrat', '13.6', 'g']] as [$label, $value, $unit])
                            <div
                                style="padding:15px 16px;border-radius:var(--radius);background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1)">
                                <div class="small" style="color:var(--ink-muted)">{{ $label }}</div>
                                <div class="tabular"
                                    style="margin-top:6px;font-size:1.4rem;font-weight:800;letter-spacing:-.03em;color:#fff">
                                    {{ $value }}<span
                                        style="font-size:.8rem;font-weight:600;color:var(--ink-muted)"> {{ $unit }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row mt-4"
                        style="gap:10px;padding:13px 15px;border-radius:var(--radius);background:rgba(74,222,128,.09);border:1px solid rgba(74,222,128,.22)">
                        <span aria-hidden="true">⭐</span>
                        <span class="small" style="color:var(--ink-text)">Tersimpan di favorites &amp; riwayat harian</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ────────────────────────────────────────────────────────── METRIK ── --}}
    <section class="section-tight" style="background:var(--bg-subtle);border-bottom:1px solid var(--border)">
        <div class="container">
            <div class="grid grid-4">
                <div class="stat reveal" style="--brand:var(--sipintar)">
                    <div class="stat-value" data-count="1000" data-suffix="+">1000+</div>
                    <div class="stat-label">Menu makanan</div>
                </div>
                <div class="stat reveal" style="--brand:var(--sipintar)">
                    <div class="stat-value" data-count="50" data-suffix="+">50+</div>
                    <div class="stat-label">Kategori makanan</div>
                </div>
                <div class="stat reveal" style="--brand:var(--sipintar)">
                    <div class="stat-value" data-count="15" data-suffix="+">15+</div>
                    <div class="stat-label">Informasi nutrisi</div>
                </div>
                <div class="stat reveal" style="--brand:var(--sipintar)">
                    <div class="stat-value">24/7</div>
                    <div class="stat-label">Akses gratis</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─────────────────────────────────────────────────────────── FITUR ── --}}
    <section class="section" id="fitur">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow" style="color:var(--sipintar)">Fitur unggulan</span>
                <h2>Dari penasaran jadi paham</h2>
                <p>Setiap fitur dirancang agar informasi nutrisi terasa relevan dengan apa yang benar-benar dimakan siswa
                    setiap hari.</p>
            </div>

            <div class="grid grid-3">
                @foreach ([
                    ['🍽️', 'Browse menu makanan', 'Jelajahi ribuan menu dengan informasi nutrisi lengkap. Tidak perlu login untuk melihat konten.'],
                    ['📊', 'Tracking konsumsi', 'Catat makanan yang dikonsumsi setiap hari dengan sistem tracking yang mudah dan akurat.'],
                    ['❤️', 'Favorites & history', 'Simpan makanan favorit dan tinjau riwayat konsumsi untuk memperbaiki pola makan.'],
                    ['📚', 'Konten edukasi', 'Tips makan sehat, panduan gizi seimbang, dan materi edukatif untuk semua usia.'],
                    ['🔍', 'Pencarian cerdas', 'Cari berdasarkan nama, kategori, atau kandungan nutrisi dengan hasil yang relevan.'],
                    ['🛡️', 'Privacy first', 'Data Anda aman dan terlindungi, dengan kontrol penuh sesuai standar GDPR/CCPA.'],
                ] as [$icon, $heading, $body])
                    <article class="card card-hover card-accent reveal"
                        style="--accent:var(--sipintar);--accent-soft:var(--sipintar-soft)">
                        <div class="card-icon" aria-hidden="true">{{ $icon }}</div>
                        <h3>{{ $heading }}</h3>
                        <p>{{ $body }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ──────────────────────────────────────────────────────── CARA KERJA ── --}}
    <section class="section section-subtle" id="cara-kerja">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow" style="color:var(--sipintar)">Cara kerja</span>
                <h2>Mulai dalam empat langkah</h2>
            </div>

            <div class="steps grid grid-4">
                @foreach ([
                    ['Download & install', 'Unduh Sipintar dari Play Store atau App Store secara gratis.'],
                    ['Browse tanpa login', 'Jelajahi menu dan informasi nutrisi tanpa perlu membuat akun terlebih dahulu.'],
                    ['Login untuk fitur personal', 'Buat akun untuk menyimpan favorites, tracking konsumsi, dan fitur personal lainnya.'],
                    ['Mulai hidup sehat', 'Pantau konsumsi harian dan pelajari nutrisi untuk kebiasaan makan yang lebih baik.'],
                ] as [$heading, $body])
                    <div class="step reveal" style="--brand:var(--sipintar)">
                        <h3>{{ $heading }}</h3>
                        <p>{{ $body }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ───────────────────────────────────────────────────────── SEKOLAH ── --}}
    <section class="section" id="sekolah">
        <div class="container">
            <div class="grid grid-2" style="align-items:start;gap:clamp(32px,5vw,64px)">
                <div class="reveal">
                    <span class="eyebrow" style="color:var(--sipintar)">Untuk sekolah</span>
                    <h2>Program jajanan sehat yang benar-benar terukur</h2>
                    <p class="lead mt-3">
                        Sipintar bukan sekadar aplikasi siswa. Sekolah mendapat gambaran nyata tentang pola konsumsi dan
                        keterlibatan, sehingga program kesehatan bisa dievaluasi dengan data.
                    </p>

                    <ul class="list-check mt-5" style="--check:var(--sipintar)">
                        <li><strong>Kampanye berbasis data</strong> — arahkan program dari pola konsumsi nyata</li>
                        <li><strong>Gamifikasi</strong> — tingkatkan partisipasi siswa tanpa memaksa</li>
                        <li><strong>Laporan keterlibatan</strong> — pantau perkembangan per periode</li>
                        <li><strong>Integrasi mudah</strong> — berjalan berdampingan dengan sistem sekolah yang ada</li>
                    </ul>

                    <div class="row mt-5">
                        <a class="btn btn-primary" href="mailto:contact@amhriset.com">Ajukan Pilot Project</a>
                    </div>
                </div>

                <div class="card reveal">
                    <span class="eyebrow" style="color:var(--sipintar)">Cakupan data</span>
                    <h3>Apa yang bisa dipantau</h3>

                    <div class="spec mt-4">
                        <div class="spec-row">
                            <span class="spec-key">Database menu</span>
                            <span class="spec-val">1000+ item</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Kategori makanan</span>
                            <span class="spec-val">50+</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Atribut nutrisi</span>
                            <span class="spec-val">15+ per menu</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Riwayat konsumsi</span>
                            <span class="spec-val">Per pengguna</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Biaya penggunaan</span>
                            <span class="spec-val">Gratis</span>
                        </div>
                    </div>

                    <p class="small muted mt-4">
                        Data agregat digunakan untuk evaluasi program; identitas siswa tidak dipublikasikan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ──────────────────────────────────────────────────────── DOWNLOAD ── --}}
    <section class="section section-subtle" id="download">
        <div class="container">
            <div class="cta-panel on-ink reveal" style="--brand:var(--sipintar)">
                <h2>Siap memulai perjalanan sehat?</h2>
                <p>
                    Download Sipintar dan mulai pelajari nutrisi makanan dengan cara yang menyenangkan — gratis, tanpa
                    iklan, dan privacy-first.
                </p>
                <div class="hero-actions">
                    <a class="btn btn-primary btn-lg" href="#">📱 Google Play Store</a>
                    <a class="btn btn-secondary btn-lg" href="#">🍎 Apple App Store</a>
                </div>
                <p class="small" style="margin-top:22px;color:var(--ink-muted)">
                    Gratis • Tanpa iklan • Privacy-first
                </p>
            </div>
        </div>
    </section>

@endsection
