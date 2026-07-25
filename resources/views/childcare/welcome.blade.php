@extends('layouts.public')

@section('title', $title ?? 'Child Care — Smart Shoe Monitoring')
@section('description', 'Child Care: sepatu pintar untuk memantau detak jantung, suhu tubuh, kelembapan, tingkat kecemasan, dan lokasi anak secara real-time. Terintegrasi dengan aplikasi Android.')

@section('nav_links')
    <a href="#fitur">Fitur</a>
    <a href="#sensor">Sensor</a>
    <a href="#cara-kerja">Cara Kerja</a>
    <a href="#privasi">Privasi</a>
    <a href="#download">Download</a>
@endsection

@section('nav_actions')
    <a class="btn btn-primary btn-sm" href="#download">Dapatkan Aplikasi</a>
@endsection

@section('content')

    {{-- ─────────────────────────────────────────────────────────── HERO ── --}}
    <section class="hero on-ink" style="--brand:var(--childcare)">
        <div class="container">
            <div class="hero-split">
                <div>
                    <span class="chip chip-ink chip-dot">IoT • Wearable</span>

                    <h1 class="mt-3">Ketenangan pikiran, langsung dari sepatu anak Anda</h1>

                    <p class="lead">
                        Child Care memantau detak jantung, suhu tubuh, kelembapan, tingkat kecemasan, dan lokasi anak
                        secara real-time. Sensor tertanam rapi di dalam sepatu dan sinkron otomatis ke aplikasi.
                    </p>

                    <div class="hero-actions">
                        <a class="btn btn-primary btn-lg" href="#download">Dapatkan Aplikasi</a>
                        <a class="btn btn-secondary btn-lg" href="#cara-kerja">Lihat Cara Kerja</a>
                    </div>

                    <div class="hero-chips">
                        <span class="chip chip-ink">Sinkron otomatis</span>
                        <span class="chip chip-ink">Notifikasi anomali</span>
                        <span class="chip chip-ink">Data terenkripsi</span>
                    </div>
                </div>

                {{-- Live-monitor mock panel --}}
                <div class="card reveal"
                    style="background:rgba(255,255,255,.05);border-color:rgba(255,255,255,.13);backdrop-filter:blur(14px)">
                    <div class="row" style="justify-content:space-between">
                        <div>
                            <div class="small" style="color:var(--ink-muted)">Perangkat aktif</div>
                            <strong style="color:#fff;font-size:1.05rem">Sepatu Aira</strong>
                        </div>
                        <span class="chip chip-ink chip-dot" style="color:#4ade80">Live</span>
                    </div>

                    <div class="grid grid-2 mt-4" style="gap:12px">
                        @foreach ([
                            ['💗', 'Detak jantung', '96', 'bpm'],
                            ['🌡️', 'Suhu tubuh', '36.8', '°C'],
                            ['💧', 'Kelembapan', '54', '%'],
                            ['🧠', 'Kecemasan', 'Normal', ''],
                        ] as [$icon, $label, $value, $unit])
                            <div
                                style="padding:15px 16px;border-radius:var(--radius);background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1)">
                                <div class="small" style="color:var(--ink-muted)">
                                    <span aria-hidden="true">{{ $icon }}</span> {{ $label }}
                                </div>
                                <div class="tabular"
                                    style="margin-top:6px;font-size:1.4rem;font-weight:800;letter-spacing:-.03em;color:#fff">
                                    {{ $value }}<span
                                        style="font-size:.8rem;font-weight:600;color:var(--ink-muted)">{{ $unit ? ' ' . $unit : '' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row mt-4"
                        style="gap:10px;padding:13px 15px;border-radius:var(--radius);background:rgba(74,222,128,.09);border:1px solid rgba(74,222,128,.22)">
                        <span aria-hidden="true">📍</span>
                        <span class="small" style="color:var(--ink-text)">Lokasi terakhir diperbarui 12 detik lalu</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ────────────────────────────────────────────────────────── METRIK ── --}}
    <section class="section-tight" style="background:var(--bg-subtle);border-bottom:1px solid var(--border)">
        <div class="container">
            <div class="grid grid-4">
                <div class="stat reveal" style="--brand:var(--childcare)">
                    <div class="stat-value">24/7</div>
                    <div class="stat-label">Monitoring real-time</div>
                </div>
                <div class="stat reveal" style="--brand:var(--childcare)">
                    <div class="stat-value" data-count="5" data-suffix="+">5+</div>
                    <div class="stat-label">Sensor terintegrasi</div>
                </div>
                <div class="stat reveal" style="--brand:var(--childcare)">
                    <div class="stat-value">GPS</div>
                    <div class="stat-label">Pelacakan lokasi</div>
                </div>
                <div class="stat reveal" style="--brand:var(--childcare)">
                    <div class="stat-value" data-count="30" data-suffix="s">30s</div>
                    <div class="stat-label">Interval pembaruan</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─────────────────────────────────────────────────────────── FITUR ── --}}
    <section class="section" id="fitur">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow" style="color:var(--childcare)">Fitur</span>
                <h2>Semua yang orang tua butuhkan, dalam satu aplikasi</h2>
                <p>Dirancang agar informasi penting terbaca dalam sekali lihat — tanpa mengganggu aktivitas anak.</p>
            </div>

            <div class="grid grid-3">
                @foreach ([
                    ['💗', 'Vital sign real-time', 'Detak jantung, suhu tubuh, dan kelembapan direkam terus-menerus dan dikirim otomatis ke aplikasi.'],
                    ['🧠', 'Deteksi kecemasan', 'Pola sensor dianalisis untuk mengenali kondisi tidak normal, lalu memicu notifikasi ke orang tua.'],
                    ['📍', 'Pelacakan lokasi', 'Posisi anak dapat dibuka langsung di Google Maps dari kartu lokasi di aplikasi.'],
                    ['📈', 'Grafik tren', 'Riwayat setiap sensor divisualisasikan sebagai grafik agar perubahan mudah dikenali.'],
                    ['🔔', 'Notifikasi kritis', 'Peringatan dikirim saat ada anomali sehingga Anda bisa segera bertindak.'],
                    ['👥', 'Berbagi akses', 'Wali atau anggota keluarga lain dapat diberi akses untuk ikut memantau.'],
                ] as [$icon, $heading, $body])
                    <article class="card card-hover card-accent reveal"
                        style="--accent:var(--childcare);--accent-soft:var(--childcare-soft)">
                        <div class="card-icon" aria-hidden="true">{{ $icon }}</div>
                        <h3>{{ $heading }}</h3>
                        <p>{{ $body }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ────────────────────────────────────────────────────────── SENSOR ── --}}
    <section class="section section-subtle" id="sensor">
        <div class="container">
            <div class="grid grid-2" style="align-items:start;gap:clamp(32px,5vw,64px)">
                <div class="reveal">
                    <span class="eyebrow" style="color:var(--childcare)">Perangkat</span>
                    <h2>Sensor tertanam, anak tetap bebas bergerak</h2>
                    <p class="lead mt-3">
                        Seluruh modul sensor terpasang di dalam sol sepatu. Tidak ada perangkat tambahan yang harus
                        dipakai anak, dan tidak ada kabel yang mengganggu.
                    </p>

                    <ul class="list-check mt-5" style="--check:var(--childcare)">
                        <li><strong>Modul detak jantung</strong> — pembacaan berkala saat anak beraktivitas</li>
                        <li><strong>Sensor suhu &amp; kelembapan</strong> — memantau kondisi tubuh dan lingkungan</li>
                        <li><strong>Modul lokasi</strong> — koordinat lat/lng dikirim bersama data sensor</li>
                        <li><strong>Konektivitas nirkabel</strong> — data diteruskan ke server lalu ke aplikasi</li>
                    </ul>
                </div>

                <div class="card reveal">
                    <span class="eyebrow" style="color:var(--childcare)">Spesifikasi</span>
                    <h3>Ringkasan teknis</h3>

                    <div class="spec mt-4">
                        <div class="spec-row">
                            <span class="spec-key">Jumlah kanal sensor</span>
                            <span class="spec-val">Hingga 7</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Interval sinkronisasi</span>
                            <span class="spec-val">30 detik</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Data lokasi</span>
                            <span class="spec-val">Latitude / Longitude</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Aplikasi pendamping</span>
                            <span class="spec-val">Android</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-key">Riwayat data</span>
                            <span class="spec-val">Grafik &amp; tabel</span>
                        </div>
                    </div>

                    <p class="small muted mt-4">
                        Jumlah kanal aktif menyesuaikan konfigurasi perangkat yang Anda daftarkan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ──────────────────────────────────────────────────────── CARA KERJA ── --}}
    <section class="section" id="cara-kerja">
        <div class="container">
            <div class="section-head reveal">
                <span class="eyebrow" style="color:var(--childcare)">Cara kerja</span>
                <h2>Empat langkah, dari sepatu ke ponsel Anda</h2>
            </div>

            <div class="steps grid grid-4">
                @foreach ([
                    ['Sensor merekam', 'Modul di dalam sepatu merekam data vital dan lokasi anak secara berkala.'],
                    ['Data terkirim', 'Data diteruskan melalui koneksi nirkabel ke server Child Care.'],
                    ['Aplikasi menganalisis', 'Aplikasi menampilkan metrik terkini beserta grafik tren riwayatnya.'],
                    ['Notifikasi dikirim', 'Saat terdeteksi anomali, peringatan langsung dikirim ke orang tua.'],
                ] as [$heading, $body])
                    <div class="step reveal" style="--brand:var(--childcare)">
                        <h3>{{ $heading }}</h3>
                        <p>{{ $body }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ───────────────────────────────────────────────────────── PRIVASI ── --}}
    <section class="section section-subtle" id="privasi">
        <div class="container">
            <div class="grid grid-2" style="align-items:start;gap:clamp(32px,5vw,64px)">
                <div class="reveal">
                    <span class="eyebrow" style="color:var(--childcare)">Keamanan &amp; privasi</span>
                    <h2>Data anak Anda, kendali Anda</h2>
                    <p class="lead mt-3">
                        Data kesehatan anak adalah data paling sensitif yang kami tangani. Kami memperlakukannya sesuai
                        itu — dari transportasi hingga penyimpanan dan penghapusan.
                    </p>

                    <div class="row mt-5" style="gap:10px">
                        <a class="btn btn-secondary" href="{{ url('/tnc-child-care') }}">Baca kebijakan privasi</a>
                        <a class="btn btn-ghost" href="{{ url('/delete-account') }}">Hapus akun &amp; data</a>
                    </div>
                </div>

                <div class="grid reveal" style="gap:14px">
                    @foreach ([
                        ['🔒', 'Transportasi terenkripsi', 'Seluruh komunikasi antara perangkat, server, dan aplikasi dilindungi enkripsi.'],
                        ['🎛️', 'Kontrol akses orang tua', 'Hanya akun terdaftar yang dapat melihat data perangkat miliknya.'],
                        ['🗑️', 'Hapus kapan saja', 'Perangkat dan akun beserta datanya dapat dihapus langsung oleh pengguna.'],
                        ['📋', 'Sesuai kebijakan store', 'Memenuhi persyaratan privasi Google Play untuk aplikasi anak.'],
                    ] as [$icon, $heading, $body])
                        <div class="note">
                            <span class="note-icon" aria-hidden="true">{{ $icon }}</span>
                            <span>
                                <strong>{{ $heading }}</strong>
                                {{ $body }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ──────────────────────────────────────────────────────── DOWNLOAD ── --}}
    <section class="section" id="download">
        <div class="container">
            <div class="cta-panel on-ink reveal" style="--brand:var(--childcare)">
                <h2>Mulai pantau anak Anda hari ini</h2>
                <p>
                    Unduh aplikasi pendamping, daftarkan sepatu pintar Anda dengan alamat perangkat, dan data akan mulai
                    tampil di dashboard dalam hitungan menit.
                </p>
                <div class="hero-actions">
                    <a class="btn btn-primary btn-lg" href="#">📱 Google Play Store</a>
                    <a class="btn btn-secondary btn-lg" href="mailto:contact@amhriset.com">Hubungi Kami</a>
                </div>
                <p class="small" style="margin-top:22px;color:var(--ink-muted)">
                    Butuh bantuan pemasangan? Tim kami merespons maksimal 1×24 jam.
                </p>
            </div>
        </div>
    </section>

@endsection
