<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Child Care - Smart Shoe Monitoring' }}</title>
    <meta name="description"
        content="Child Care - Sepatu pintar untuk monitoring anak: detak jantung, suhu tubuh, kelembapan tubuh, kecemasan, dan lokasi. Terintegrasi aplikasi Android.">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            line-height: 1.6;
            color: #111;
            background: #0f172a
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0
        }

        .logo {
            color: #fff;
            text-decoration: none;
            font-weight: 800
        }

        .nav-links {
            display: flex;
            gap: 20px;
            list-style: none
        }

        .nav-links a {
            color: #cbd5e1;
            text-decoration: none
        }

        .nav-links a:hover {
            color: #fff
        }

        .hero {
            padding: 64px 0;
            color: #fff
        }

        .hero h1 {
            font-size: 2.3rem;
            font-weight: 800;
            margin-bottom: 10px
        }

        .hero p {
            color: #cbd5e1;
            max-width: 760px
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 28px
        }

        .card {
            background: #111827;
            border: 1px solid #1f2937;
            border-radius: 14px;
            padding: 20px;
            color: #e5e7eb
        }

        .badge {
            display: inline-block;
            background: #1d4ed8;
            color: #fff;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: .8rem;
            font-weight: 700
        }

        .features {
            margin-top: 12px
        }

        .features li {
            margin-left: 18px;
            color: #cbd5e1
        }

        .metrics {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 20px
        }

        .metric {
            background: #0b1220;
            border: 1px solid #1f2937;
            border-radius: 12px;
            padding: 16px;
            color: #cbd5e1;
            text-align: center
        }

        .metric h3 {
            color: #fff;
            font-size: 1.6rem
        }

        .section {
            padding: 48px 0
        }

        .section h2 {
            color: #fff;
            font-size: 1.6rem;
            margin-bottom: 10px
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            font-weight: 800;
            border-radius: 10px;
            padding: 12px 16px
        }

        .btn-primary {
            background: #22c55e;
            color: #0f172a
        }

        .btn-outline {
            border: 1px solid #334155;
            color: #e5e7eb
        }

        .footer {
            border-top: 1px solid #1f2937;
            margin-top: 48px;
            padding: 24px 0;
            color: #94a3b8;
            text-align: center
        }

        @media(max-width:900px) {
            .grid {
                grid-template-columns: 1fr
            }

            .metrics {
                grid-template-columns: repeat(2, 1fr)
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <nav class="nav">
                <a href="/" class="logo">amhriset.com</a>
                <ul class="nav-links">
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#cara-kerja">Cara Kerja</a></li>
                    <li><a href="#download">Download</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <span class="badge">IoT • Wearable</span>
            <h1>Child Care — Smart Shoe Monitoring</h1>
            <p>Sepatu pintar untuk orang tua: pantau detak jantung, suhu, kelembapan tubuh, tingkat kecemasan, dan
                lokasi anak secara real-time. Sensor & tracking terintegrasi di sepatu, sinkron ke aplikasi.</p>
            <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap">
                <a class="btn btn-primary" href="#download">Dapatkan Aplikasi</a>
                <a class="btn btn-outline" href="/">Produk Lainnya</a>
            </div>
            <div class="metrics">
                <div class="metric">
                    <h3>24/7</h3>
                    <div>Monitoring Real-Time</div>
                </div>
                <div class="metric">
                    <h3>5+</h3>
                    <div>Sensor Terintegrasi</div>
                </div>
                <div class="metric">
                    <h3>LTE/GPS</h3>
                    <div>Pelacakan Lokasi</div>
                </div>
                <div class="metric">
                    <h3>Alert</h3>
                    <div>Notifikasi Cerdas</div>
                </div>
            </div>
        </div>
    </section>

    <main class="section" id="fitur">
        <div class="container grid">
            <div class="card">
                <h2>Fitur Utama</h2>
                <ul class="features">
                    <li>Pemantauan detak jantung, suhu, dan kelembapan tubuh</li>
                    <li>Deteksi kecemasan berbasis pola sensor</li>
                    <li>Pelacakan lokasi anak (GPS)</li>
                    <li>Notifikasi kondisi kritis ke orang tua</li>
                    <li>Riwayat data dan grafik tren</li>
                    <li>Sinkronisasi real-time ke aplikasi Android</li>
                </ul>
            </div>
            <div class="card">
                <h2>Keamanan & Privasi</h2>
                <ul class="features">
                    <li>Enkripsi data end-to-end</li>
                    <li>Kontrol akses data oleh orang tua</li>
                    <li>Penghapusan dan ekspor data</li>
                    <li>Kompatibel dengan kebijakan store</li>
                </ul>
            </div>
        </div>
    </main>

    <section class="section" id="cara-kerja">
        <div class="container grid">
            <div class="card">
                <h2>Cara Kerja</h2>
                <ol style="margin-left:18px;color:#cbd5e1">
                    <li>Sensor di sepatu merekam data vital anak</li>
                    <li>Data dikirim ke ponsel melalui koneksi nirkabel</li>
                    <li>Aplikasi menganalisis dan menampilkan metrik</li>
                    <li>Notifikasi dikirim saat ada anomali</li>
                </ol>
            </div>
            <div class="card">
                <h2>Integrasi</h2>
                <ul class="features">
                    <li>Android (Play Store) — aplikasi pendamping</li>
                    <li>Dashboard tren harian/mingguan</li>
                    <li>Berbagi akses dengan wali</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section" id="download">
        <div class="container">
            <h2 style="color:#fff">Download</h2>
            <p style="color:#cbd5e1">Aplikasi pendamping tersedia di Play Store. Unduh untuk menghubungkan sepatu pintar
                Anda dan mulai memantau.</p>
            <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap">
                <a class="btn btn-primary" href="#">📱 Google Play Store</a>
                <a class="btn btn-outline" href="mailto:contact@amhriset.com">Hubungi Kami</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">© {{ date('Y') }} amhriset.com — Child Care</div>
    </footer>
</body>

</html>