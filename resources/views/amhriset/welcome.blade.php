@extends('layouts.public')

@section('title', $title ?? 'amhriset.com — Riset & Produk Teknologi')
@section('description', 'amhriset.com menghadirkan Child Care (smart shoe monitoring berbasis IoT) dan Sipintar (edukasi nutrisi & gamifikasi jajanan sehat) untuk keluarga dan institusi pendidikan.')

@section('nav_links')
    <a href="#produk">Produk</a>
    <a href="#solusi">Solusi</a>
    <a href="#tentang">Tentang</a>
    <a href="#kontak">Kontak</a>
@endsection

@section('content')

    {{-- ─────────────────────────────────────────────────────────── HERO ── --}}
    <section class="hero on-ink">
        <div class="container">
            <div class="hero-split">
                <div>
                    <span class="chip chip-ink chip-dot">Riset &amp; produk teknologi</span>

                    <h1 class="mt-3">Teknologi berbasis riset untuk keluarga dan pendidikan</h1>

                    <p class="lead">
                        Kami menggabungkan IoT, analitik data, dan desain yang berpusat pada manusia — dari monitoring
                        kesehatan anak secara real-time hingga edukasi nutrisi yang interaktif.
                    </p>

                    <div class="hero-actions">
                        <a class="btn btn-primary btn-lg" href="#produk">Jelajahi Produk</a>
                        <a class="btn btn-secondary btn-lg" href="#solusi">Lihat Solusi</a>
                    </div>

                    <div class="hero-chips">
                        <span class="chip chip-ink">Sesuai GDPR &amp; CCPA</span>
                        <span class="chip chip-ink">Tersedia di Play Store</span>
                        <span class="chip chip-ink">Analitik real-time</span>
                    </div>
                </div>

                {{-- Product preview cards --}}
                <div class="grid" style="--stack:0;gap:16px">
                    <a href="{{ url('/child-care') }}" class="card card-hover card-accent"
                        style="--accent:var(--childcare);--accent-soft:var(--childcare-soft);background:rgba(255,255,255,.05);border-color:rgba(255,255,255,.12);backdrop-filter:blur(12px)">
                        <div class="card-icon" aria-hidden="true">👟</div>
                        <h3 style="color:#fff">Child Care</h3>
                        <p style="color:var(--ink-muted)">
                            Sepatu pintar yang memantau detak jantung, suhu tubuh, kelembapan, dan lokasi anak — langsung
                            ke ponsel Anda.
                        </p>
                        <span class="chip chip-ink mt-3" style="align-self:flex-start">IoT &amp; Wearable →</span>
                    </a>

                    <a href="{{ url('/sipintar') }}" class="card card-hover card-accent"
                        style="--accent:var(--sipintar);--accent-soft:var(--sipintar-soft);background:rgba(255,255,255,.05);border-color:rgba(255,255,255,.12);backdrop-filter:blur(12px)">
                        <div class="card-icon" aria-hidden="true">🥗</div>
                        <h3 style="color:#fff">Sipintar</h3>
                        <p style="color:var(--ink-muted)">
                            Platform edukasi nutrisi dengan gamifikasi — membantu sekolah membangun budaya jajanan sehat
                            berbasis data.
                        </p>
                        <span class="chip chip-ink mt-3" style="align-self:flex-start">Edukasi &amp; Gamifikasi →</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ────────────────────────────────────────────────────────── STATS ── --}}
    <section class="section-tight" style="background:var(--bg-subtle);border-bottom:1px solid var(--border)">
        <div class="container">
            <div class="grid grid-4">
                <div class="stat reveal">
                    <div class="stat-value" data-count="1000" data-suffix="+">1000+</div>
                    <div class="stat-label">Pengguna aktif</div>
                </div>
                <div class="stat reveal">
                    <div class="stat-value" data-count="50" data-suffix="+">50+</div>
                    <div class="stat-label">Sekolah mitra</div>
                </div>
                <div class="stat reveal">
                    <div class="stat-value">24/7</div>
                    <div class="stat-label">Monitoring support</div>
                </div>
                <div class="stat reveal">
                    <div class="stat-value" data-count="98" data-suffix="%">98%</div>
                    <div class="stat-label">Kepuasan pengguna</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─────────────────────────────────────────────────────── PRODUCTS ── --}}
    <section class="section" id="produk">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow">Produk</span>
                <h2>Dua produk, satu ekosistem</h2>
                <p>
                    Setiap produk dirancang dengan pendekatan berbasis riset dan teknologi terkini, dengan nilai nyata
                    bagi keluarga maupun institusi pendidikan.
                </p>
            </div>

            <div class="grid grid-2">
                {{-- Child Care --}}
                <article class="card card-hover card-accent reveal"
                    style="--accent:var(--childcare);--accent-soft:var(--childcare-soft)">
                    <div class="row" style="justify-content:space-between;align-items:flex-start">
                        <div class="card-icon" aria-hidden="true">👟</div>
                        <span class="chip chip-childcare">IoT &amp; Wearable</span>
                    </div>

                    <h3>Child Care — Smart Shoe Monitoring</h3>
                    <p>
                        Teknologi terdepan dalam satu sepatu. Pantau kesehatan dan keamanan anak secara real-time melalui
                        sensor cerdas yang terintegrasi langsung dengan aplikasi mobile.
                    </p>

                    <ul class="list-check mt-4">
                        <li>Monitoring real-time detak jantung, suhu tubuh, dan kelembapan</li>
                        <li>Deteksi kecemasan berbasis pola sensor dengan notifikasi instan</li>
                        <li>Pelacakan lokasi GPS yang akurat dan aman</li>
                        <li>Dashboard analitik untuk tren kesehatan harian</li>
                    </ul>

                    <div class="card-footer row">
                        <a class="btn btn-primary" href="{{ url('/child-care') }}">Pelajari Child Care</a>
                        <a class="btn btn-ghost" href="{{ url('/tnc-child-care') }}">Kebijakan privasi</a>
                    </div>
                </article>

                {{-- Sipintar --}}
                <article class="card card-hover card-accent reveal"
                    style="--accent:var(--sipintar);--accent-soft:var(--sipintar-soft)">
                    <div class="row" style="justify-content:space-between;align-items:flex-start">
                        <div class="card-icon" aria-hidden="true">🥗</div>
                        <span class="chip chip-sipintar">Edukasi &amp; Gamifikasi</span>
                    </div>

                    <h3>Sipintar — Edukasi Nutrisi Interaktif</h3>
                    <p>
                        Transformasi cara siswa belajar tentang nutrisi melalui gamifikasi yang menyenangkan, dengan
                        pendekatan data-driven dan tingkat keterlibatan yang tinggi.
                    </p>

                    <ul class="list-check mt-4">
                        <li>Database jajanan lengkap dengan informasi nutrisi akurat</li>
                        <li>Sistem gamifikasi untuk meningkatkan keterlibatan siswa</li>
                        <li>Tracking konsumsi harian, favorites, dan riwayat personal</li>
                        <li>Akses tanpa login untuk menjelajahi informasi nutrisi</li>
                    </ul>

                    <div class="card-footer row">
                        <a class="btn btn-primary" href="{{ url('/sipintar') }}">Jelajahi Sipintar</a>
                        <a class="btn btn-ghost" href="{{ url('/privacy-policy') }}">Kebijakan privasi</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- ────────────────────────────────────────────────────────── SOLUSI ── --}}
    <section class="section section-subtle" id="solusi">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow">Solusi</span>
                <h2>Dirancang untuk setiap kebutuhan</h2>
                <p>
                    Dari orang tua yang peduli keamanan anak hingga institusi yang ingin membangun program kesehatan
                    berbasis data.
                </p>
            </div>

            <div class="grid grid-3">
                <article class="card card-hover reveal">
                    <div class="card-icon" aria-hidden="true">👨‍👩‍👧</div>
                    <h3>Untuk Orang Tua</h3>
                    <p>Ketenangan pikiran lewat teknologi yang terpercaya dan mudah digunakan.</p>
                    <ul class="list-check mt-4">
                        <li>Monitoring kesehatan anak 24/7</li>
                        <li>Notifikasi instan saat kondisi tidak normal</li>
                        <li>Riwayat kesehatan dan tren analitik</li>
                        <li>Privasi data sesuai standar GDPR/CCPA</li>
                    </ul>
                </article>

                <article class="card card-hover reveal">
                    <div class="card-icon" aria-hidden="true">🏫</div>
                    <h3>Untuk Sekolah</h3>
                    <p>Bangun program kesehatan dan nutrisi yang efektif dengan data yang terukur.</p>
                    <ul class="list-check mt-4">
                        <li>Kampanye jajanan sehat berbasis analytics</li>
                        <li>Program gamifikasi untuk partisipasi siswa</li>
                        <li>Laporan konsumsi dan keterlibatan yang detail</li>
                        <li>Integrasi mudah dengan sistem sekolah</li>
                    </ul>
                </article>

                <article class="card card-hover reveal">
                    <div class="card-icon" aria-hidden="true">🏛️</div>
                    <h3>Untuk Dinas &amp; Komunitas</h3>
                    <p>Skalakan inisiatif kesehatan anak dan edukasi nutrisi ke level regional.</p>
                    <ul class="list-check mt-4">
                        <li>Implementasi program skala besar</li>
                        <li>Edukasi nutrisi terstruktur dan berkelanjutan</li>
                        <li>Pelatihan dan pendampingan untuk staf</li>
                        <li>Evaluasi program berbasis metrik dan KPI</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    {{-- ───────────────────────────────────────────────────────── TENTANG ── --}}
    <section class="section" id="tentang">
        <div class="container">
            <div class="grid grid-2" style="align-items:start;gap:clamp(32px,5vw,64px)">
                <div class="reveal">
                    <span class="eyebrow">Tentang kami</span>
                    <h2>Riset dulu, produk kemudian</h2>
                    <p class="lead mt-3">
                        Kami membangun ekosistem teknologi yang mendukung keluarga dan pendidikan dengan cara yang
                        berkelanjutan dan etis — dengan fokus pada riset mendalam dan pengembangan yang berpusat pada
                        pengguna.
                    </p>

                    <ul class="list-check mt-5">
                        <li><strong>Keamanan &amp; privasi data</strong> sebagai standar fundamental di setiap produk</li>
                        <li><strong>Desain inklusif</strong> yang dapat diakses semua kalangan pengguna</li>
                        <li><strong>Kolaborasi aktif</strong> dengan sekolah, orang tua, dan komunitas</li>
                        <li><strong>Pendekatan berbasis riset</strong> untuk memastikan efektivitas solusi</li>
                    </ul>
                </div>

                <div class="card reveal">
                    <span class="eyebrow">Kapabilitas</span>
                    <h3>Keunggulan teknologi kami</h3>

                    <div class="spec mt-4">
                        <div class="spec-row">
                            <span class="spec-key">Integrasi IoT &amp; mobile</span>
                            <span class="spec-val">Seamless</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Pemrosesan data</span>
                            <span class="spec-val">Real-time</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Arsitektur</span>
                            <span class="spec-val">Scalable</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Infrastruktur</span>
                            <span class="spec-val">Cloud</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Analitik</span>
                            <span class="spec-val">Actionable</span>
                        </div>
                    </div>

                    <p class="small muted mt-4">
                        Setiap kapabilitas divalidasi lewat pilot project bersama sekolah dan keluarga pengguna sebelum
                        dirilis luas.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ───────────────────────────────────────────────────── TESTIMONIALS ── --}}
    <section class="section section-subtle">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow">Testimoni</span>
                <h2>Apa kata pengguna kami</h2>
            </div>

            <div class="grid grid-2">
                <figure class="card card-hover reveal">
                    <div style="font-size:2rem;line-height:1;color:var(--brand);opacity:.35" aria-hidden="true">&ldquo;</div>
                    <blockquote style="margin-top:8px;font-size:1.05rem;line-height:1.75;color:var(--text)">
                        Sebagai orang tua yang bekerja, Child Care memberikan ketenangan yang luar biasa. Saya bisa
                        memantau kesehatan anak kapan saja, dan notifikasinya sangat responsif.
                    </blockquote>
                    <figcaption class="row mt-4" style="gap:12px">
                        <span aria-hidden="true"
                            style="display:grid;place-items:center;width:40px;height:40px;border-radius:50%;background:var(--brand-soft);color:var(--brand-text);font-weight:800">S</span>
                        <span>
                            <strong style="display:block">Ibu Sarah</strong>
                            <span class="small muted">Pengguna Child Care</span>
                        </span>
                    </figcaption>
                </figure>

                <figure class="card card-hover reveal">
                    <div style="font-size:2rem;line-height:1;color:var(--brand);opacity:.35" aria-hidden="true">&ldquo;</div>
                    <blockquote style="margin-top:8px;font-size:1.05rem;line-height:1.75;color:var(--text)">
                        Sipintar membantu sekolah kami membangun program jajanan sehat yang efektif. Siswa antusias
                        dengan gamifikasinya, dan dashboard analytics sangat membantu evaluasi program.
                    </blockquote>
                    <figcaption class="row mt-4" style="gap:12px">
                        <span aria-hidden="true"
                            style="display:grid;place-items:center;width:40px;height:40px;border-radius:50%;background:var(--sipintar-soft);color:var(--sipintar-text);font-weight:800">B</span>
                        <span>
                            <strong style="display:block">Pak Budi</strong>
                            <span class="small muted">Kepala Sekolah, Mitra Sipintar</span>
                        </span>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    {{-- ────────────────────────────────────────────────────────── KONTAK ── --}}
    <section class="section" id="kontak">
        <div class="container">
            <div class="cta-panel on-ink reveal">
                <h2>Siap memulai perjalanan bersama kami?</h2>
                <p>
                    Tim kami siap memberikan demo produk, menjalankan pilot project di sekolah Anda, atau membangun
                    kemitraan program kesehatan anak dan edukasi nutrisi yang berkelanjutan.
                </p>
                <div class="hero-actions">
                    <a class="btn btn-primary btn-lg" href="mailto:contact@amhriset.com">Hubungi Tim Kami</a>
                    <a class="btn btn-secondary btn-lg" href="#produk">Jelajahi Produk</a>
                </div>
            </div>
        </div>
    </section>

@endsection
