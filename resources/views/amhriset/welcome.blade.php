<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'amhriset.com - Riset & Produk' }}</title>
    <meta name="description"
        content="amhriset.com - Riset dan produk: Child Care (smart shoe monitoring) dan Sipintar (edukasi nutrisi & gamifikasi jajanan sehat).">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/FTII.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f6f9fc
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px
        }

        .header {
            position: sticky;
            top: 0;
            background: #fff;
            border-bottom: 1px solid #eef2f7;
            z-index: 10
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0
        }

        .logo {
            font-weight: 800;
            color: #111;
            text-decoration: none;
            font-size: 1.25rem
        }

        .nav-links {
            display: flex;
            gap: 24px;
            list-style: none
        }

        .nav-links a {
            text-decoration: none;
            color: #444;
            font-weight: 600
        }

        .nav-links a:hover {
            color: #111
        }

        .hero {
            background: linear-gradient(135deg, #111827, #1f2937);
            color: #fff;
            padding: 72px 0
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 12px
        }

        .hero p {
            opacity: .9;
            max-width: 760px
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            margin-top: 18px;
            flex-wrap: wrap
        }

        .badge-grid {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #334155;
            color: #cbd5e1;
            background: #0b1220;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: .9rem
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 36px
        }

        .card {
            background: #fff;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            padding: 24px
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 700;
            margin-bottom: 10px
        }

        .badge-green {
            background: #ecfdf5;
            color: #065f46
        }

        .badge-blue {
            background: #eff6ff;
            color: #1e40af
        }

        .card h3 {
            font-size: 1.35rem;
            margin-bottom: 8px
        }

        .card p {
            color: #555
        }

        .features {
            margin-top: 16px
        }

        .features li {
            margin-left: 18px;
            color: #444
        }

        .cta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 16px
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            font-weight: 700;
            border-radius: 10px;
            padding: 12px 16px
        }

        .btn-primary {
            background: #111;
            color: #fff
        }

        .btn-outline {
            border: 1px solid #cbd5e1;
            color: #111
        }

        .btn-dark {
            background: #111;
            color: #fff
        }

        .muted {
            color: #64748b
        }

        .subtitle {
            color: #475569
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px
        }

        .section {
            padding: 56px 0
        }

        .section h2 {
            font-size: 1.8rem;
            margin-bottom: 10px
        }

        .section p.lead {
            color: #475569;
            max-width: 820px
        }

        .list-check {
            list-style: none;
            margin-top: 10px
        }

        .list-check li {
            margin-left: 0;
            position: relative;
            padding-left: 26px;
            margin-bottom: 8px
        }

        .list-check li:before {
            content: '✓';
            position: absolute;
            left: 0;
            top: 0;
            color: #16a34a;
            font-weight: 800
        }

        .footer {
            border-top: 1px solid #eef2f7;
            background: #fff;
            padding: 28px 0;
            margin-top: 56px;
            text-align: center;
            color: #6b7280;
            font-size: .95rem
        }

        @media(max-width:768px) {
            .grid-2 {
                grid-template-columns: 1fr
            }

            .hero h1 {
                font-size: 2rem
            }
        }
    </style>

    {{-- <script type="application/ld+json">
        {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "amhriset",
      "url": "{{ url('/') }}",
      "sameAs": [],
      "brand": {
        "@type": "Brand",
        "name": "amhriset"
      }
    }
    </script>
    <script type="application/ld+json">
        {
      "@context": "https://schema.org",
      "@type": "ItemList",
      "itemListElement": [
        {"@type":"ListItem","position":1,"name":"Child Care","url":"{{ url('/child-care') }}"},
        {"@type":"ListItem","position":2,"name":"Sipintar","url":"{{ url('/sipintar') }}"}
      ]
    }
    </script> --}}

</head>

<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="/" class="logo">amhriset<span style="color:#6b7280">.com</span></a>
                <ul class="nav-links">
                    <li><a href="#products">Produk</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Solusi Berbasis Riset untuk Keluarga dan Pendidikan</h1>
            <p class="subtitle" style="color: #fff !important;">amhriset mengembangkan produk berdampak berbasis IoT dan data: Child Care (smart shoe
                monitoring anak) dan Sipintar (edukasi nutrisi & gamifikasi jajanan sehat).</p>
            <div class="hero-cta">
                <a class="btn btn-primary" href="#products">Lihat Produk</a>
                <a class="btn btn-outline" style="color: #fff !important;" href="#solutions">Solusi untuk Anda</a>
            </div>
            <div class="badge-grid">
                <span class="hero-badge">🛡️ GDPR/CCPA Ready</span>
                <span class="hero-badge">📱 Play Store & App Store</span>
                <span class="hero-badge">📊 Data-Driven</span>
                <span class="hero-badge">🤝 Sekolah & Orang Tua</span>
            </div>
        </div>
    </section>

    <main class="section" id="products">
        <div class="container products">
            <div class="card">
                <span class="badge badge-blue">Produk</span>
                <h3>Child Care — Smart Shoe Monitoring</h3>
                <p class="muted">Sepatu pintar untuk memantau detak jantung, suhu tubuh, kelembapan tubuh, tingkat
                    kecemasan, dan lokasi anak—terintegrasi aplikasi Android (Play Store).</p>
                <ul class="features">
                    <li>Monitoring real-time: detak jantung, suhu, kelembapan</li>
                    <li>Deteksi kecemasan dengan notifikasi cerdas</li>
                    <li>Pelacakan lokasi (GPS/LBS)</li>
                    <li>Sensor & tracking di sepatu, sinkronisasi app</li>
                </ul>
                <div class="cta">
                    <a class="btn btn-dark" href="{{ url('/child-care') }}">Lihat Child Care</a>
                    <a class="btn btn-outline" href="#">Play Store</a>
                </div>
            </div>
            <div class="card">
                <span class="badge badge-green">Produk</span>
                <h3>Sipintar — Edukasi Nutrisi & Gamifikasi</h3>
                <p class="muted">Aplikasi untuk menyimpan listing jajanan siswa dan gamifikasi konsumsi makanan sehat
                    guna meningkatkan kesadaran jajanan sehat. Tersedia di Play Store dan App Store.</p>
                <ul class="features">
                    <li>Browse jajanan & info nutrisi (tanpa login)</li>
                    <li>Gamifikasi & tracking konsumsi</li>
                    <li>Favorites & history personal</li>
                    <li>Konten edukasi nutrisi</li>
                </ul>
                <div class="cta">
                    <a class="btn btn-dark" href="{{ url('/sipintar') }}">Lihat Sipintar</a>
                    <a class="btn btn-outline" href="#">App Store</a>
                </div>
            </div>
        </div>
    </main>

    <section class="section" id="solutions">
        <div class="container">
            <h2>Solusi untuk Siapa?</h2>
            <p class="lead">Produk amhriset dirancang untuk kebutuhan nyata di lapangan, memadukan perangkat IoT,
                analitik data, dan desain berpusat pada manusia.</p>
            <div class="grid-2" style="margin-top:18px">
                <div class="card">
                    <h3>Untuk Orang Tua</h3>
                    <ul class="list-check">
                        <li>Monitoring kesehatan dan lokasi anak secara real-time</li>
                        <li>Notifikasi kondisi tidak wajar</li>
                        <li>Riwayat dan tren kesehatan</li>
                    </ul>
                </div>
                <div class="card">
                    <h3>Untuk Sekolah</h3>
                    <ul class="list-check">
                        <li>Kampanye jajanan sehat berbasis data</li>
                        <li>Program gamifikasi untuk siswa</li>
                        <li>Laporan konsumsi dan keterlibatan</li>
                    </ul>
                </div>
            </div>
            <div class="card" style="margin-top:18px">
                <h3>Untuk Dinas/Komunitas</h3>
                <ul class="list-check">
                    <li>Inisiatif kesehatan anak dan edukasi nutrisi</li>
                    <li>Pelatihan & pendampingan implementasi</li>
                    <li>Evaluasi program berbasis metrik</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section" id="about">
        <div class="container grid-2">
            <div>
                <h2>Tentang amhriset</h2>
                <p class="lead">Kami fokus pada pengembangan solusi berbasis riset yang berdampak pada keluarga dan
                    pendidikan. Kolaboratif, beretika, dan berorientasi pada hasil.</p>
                <ul class="list-check" style="margin-top:10px">
                    <li>Keamanan & Privasi Data sebagai standar</li>
                    <li>Desain inklusif untuk semua pengguna</li>
                    <li>Kolaborasi dengan sekolah, orang tua, dan komunitas</li>
                </ul>
            </div>
            <div class="card">
                <h3>Keunggulan</h3>
                <ul class="features">
                    <li>Integrasi IoT & Mobile App</li>
                    <li>Analitik & pelaporan terukur</li>
                    <li>Skalabel untuk institusi pendidikan</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section" id="testimonials">
        <div class="container">
            <h2>Apa Kata Mereka</h2>
            <div class="card" style="margin-top:12px">
                <p class="muted">“Dengan Child Care, saya merasa lebih tenang saat anak beraktivitas di luar rumah.
                    Notifikasinya cepat dan informatif.”</p>
                <p style="margin-top:8px"><strong>— Orang Tua Siswa</strong></p>
            </div>
        </div>
    </section>

    <section class="section" id="cta">
        <div class="container" style="text-align:center">
            <h2>Siap Kolaborasi atau Implementasi?</h2>
            <p class="lead" style="margin:0 auto">Hubungi kami untuk demo produk, pilot project di sekolah, atau
                kemitraan program kesehatan anak dan edukasi nutrisi.</p>
            <div class="hero-cta" style="justify-content:center">
                <a class="btn btn-primary" href="mailto:contact@amhriset.com">Hubungi Kami</a>
                <a class="btn btn-outline" href="#products">Lihat Produk</a>
            </div>
        </div>
    </section>

    <section class="section" id="contact">
        <div class="container">
            <h2>Kontak</h2>
            <p>Butuh informasi lebih lanjut, demo, atau kolaborasi?</p>
            <div class="cta" style="margin-top:10px">
                <a class="btn btn-primary" href="mailto:contact@amhriset.com">Email Kami</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            &copy; {{ date('Y') }} amhriset.com - Riset untuk Keluarga & Pendidikan
        </div>
    </footer>
</body>

</html>