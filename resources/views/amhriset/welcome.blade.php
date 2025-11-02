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
            background: #f6f9fc;
            overflow-x: hidden
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px
        }

        .header {
            position: sticky;
            top: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #eef2f7;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05)
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
            font-size: 1.25rem;
            transition: transform 0.3s ease
        }

        .logo:hover {
            transform: scale(1.05)
        }

        .nav-links {
            display: flex;
            gap: 24px;
            list-style: none
        }

        .nav-links a {
            text-decoration: none;
            color: #444;
            font-weight: 600;
            position: relative;
            transition: color 0.3s ease
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #111;
            transition: width 0.3s ease
        }

        .nav-links a:hover {
            color: #111
        }

        .nav-links a:hover::after {
            width: 100%
        }

        .hero {
            background: linear-gradient(135deg, #111827 0%, #1f2937 50%, #0f172a 100%);
            color: #fff;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(102, 126, 234, 0.1) 0%, transparent 50%);
            animation: pulse 4s ease-in-out infinite
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.5
            }

            50% {
                opacity: 0.8
            }
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
            animation: fadeInUp 0.8s ease-out
        }

        .hero p {
            opacity: .95;
            max-width: 760px;
            font-size: 1.1rem;
            animation: fadeInUp 0.8s ease-out 0.2s both
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease-out 0.4s both
        }

        .badge-grid {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 30px;
            animation: fadeInUp 0.8s ease-out 0.6s both
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #cbd5e1;
            background: rgba(11, 18, 32, 0.5);
            padding: 10px 16px;
            border-radius: 999px;
            font-size: .9rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px)
        }

        .hero-badge:hover {
            background: rgba(11, 18, 32, 0.8);
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.4)
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 50px
        }

        .card {
            background: #fff;
            border: 1px solid #eef2f7;
            border-radius: 20px;
            padding: 32px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.4s ease
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: #d1d5db
        }

        .card:hover::before {
            transform: scaleX(1)
        }

        .badge {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 700;
            margin-bottom: 16px;
            transition: transform 0.3s ease
        }

        .badge:hover {
            transform: scale(1.05)
        }

        .badge-green {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #065f46
        }

        .badge-blue {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1e40af
        }

        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 12px;
            color: #111;
            font-weight: 700
        }

        .card p {
            color: #555;
            line-height: 1.7
        }

        .features {
            margin-top: 20px;
            list-style: none
        }

        .features li {
            position: relative;
            padding-left: 24px;
            margin-bottom: 10px;
            color: #444;
            transition: color 0.3s ease
        }

        .features li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #16a34a;
            font-weight: 800;
            font-size: 1.1rem
        }

        .card:hover .features li {
            color: #333
        }

        .cta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 24px
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            font-weight: 700;
            border-radius: 12px;
            padding: 14px 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s
        }

        .btn:hover::before {
            width: 300px;
            height: 300px
        }

        .btn-primary {
            background: linear-gradient(135deg, #111, #333);
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2)
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3)
        }

        .btn-outline {
            border: 2px solid #cbd5e1;
            color: #111;
            background: transparent
        }

        .btn-outline:hover {
            background: #f8f9fa;
            border-color: #94a3b8;
            transform: translateY(-3px)
        }

        .btn-dark {
            background: linear-gradient(135deg, #111, #333);
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2)
        }

        .btn-dark:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3)
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
            gap: 30px
        }

        .section {
            padding: 80px 0;
            position: relative
        }

        .section h2 {
            font-size: 2.2rem;
            margin-bottom: 16px;
            color: #111;
            font-weight: 800;
            position: relative;
            padding-bottom: 12px
        }

        .section h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px
        }

        .section p.lead {
            color: #475569;
            max-width: 820px;
            font-size: 1.1rem;
            line-height: 1.8
        }

        .list-check {
            list-style: none;
            margin-top: 16px
        }

        .list-check li {
            margin-left: 0;
            position: relative;
            padding-left: 28px;
            margin-bottom: 12px;
            color: #444;
            line-height: 1.7
        }

        .list-check li::before {
            content: '✓';
            position: absolute;
            left: 0;
            top: 2px;
            color: #16a34a;
            font-weight: 800;
            font-size: 1.2rem;
            animation: checkmark 0.5s ease-out
        }

        @keyframes checkmark {
            0% {
                transform: scale(0) rotate(45deg);
                opacity: 0
            }

            50% {
                transform: scale(1.2) rotate(0deg)
            }

            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1
            }
        }

        .footer {
            border-top: 1px solid #eef2f7;
            background: #fff;
            padding: 40px 0;
            margin-top: 80px;
            text-align: center;
            color: #6b7280;
            font-size: .95rem
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out
        }

        .fade-in-up-delay {
            animation: fadeInUp 0.8s ease-out 0.3s both
        }

        /* Scroll animations */
        .scroll-animate {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1)
        }

        .scroll-animate.active {
            opacity: 1;
            transform: translateY(0)
        }

        /* Stats section */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 40px
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease
        }

        .stat-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15)
        }

        .stat-item h3 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 8px
        }

        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9
        }

        @media(max-width:768px) {
            .grid-2 {
                grid-template-columns: 1fr
            }

            .hero h1 {
                font-size: 2.2rem
            }

            .hero {
                padding: 60px 0 50px
            }

            .section {
                padding: 50px 0
            }

            .nav-links {
                gap: 16px;
                font-size: 0.9rem
            }
        }
    </style>
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
            <h1>Inovasi Teknologi untuk Masa Depan Keluarga & Pendidikan yang Lebih Baik</h1>
            <p class="subtitle" style="color: #fff !important;">
                Kami menghadirkan solusi berbasis riset yang menggabungkan teknologi IoT, data analytics, dan desain
                yang berpusat pada manusia. Dari monitoring kesehatan anak secara real-time hingga edukasi nutrisi
                yang interaktif—amhriset membangun ekosistem teknologi yang benar-benar berdampak.
            </p>
            <div class="hero-cta">
                <a class="btn btn-primary" href="#products">Jelajahi Produk</a>
                <a class="btn btn-outline" style="color: #fff !important; border-color: rgba(255,255,255,0.3);"
                    href="#solutions">Temukan Solusi</a>
            </div>
            <div class="badge-grid">
                <span class="hero-badge">🛡️ GDPR/CCPA Compliant</span>
                <span class="hero-badge">📱 Tersedia di Play Store & App Store</span>
                <span class="hero-badge">📊 Powered by Data Analytics</span>
                <span class="hero-badge">🤝 Trusted by Schools & Parents</span>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <h2 style="color: white; text-align: center; margin-bottom: 20px;">Dampak yang Terukur</h2>
            <div class="stats-grid">
                <div class="stat-item scroll-animate">
                    <h3>1000+</h3>
                    <p>Pengguna Aktif</p>
                </div>
                <div class="stat-item scroll-animate">
                    <h3>50+</h3>
                    <p>Sekolah Mitra</p>
                </div>
                <div class="stat-item scroll-animate">
                    <h3>24/7</h3>
                    <p>Monitoring Support</p>
                </div>
                <div class="stat-item scroll-animate">
                    <h3>98%</h3>
                    <p>Kepuasan Pengguna</p>
                </div>
            </div>
        </div>
    </section>

    <main class="section" id="products">
        <div class="container">
            <h2 class="scroll-animate">Produk Inovatif Kami</h2>
            <p class="lead scroll-animate" style="margin-top: 12px;">
                Dua produk unggulan yang telah terbukti memberikan nilai nyata bagi keluarga dan institusi pendidikan.
                Setiap produk dirancang dengan pendekatan berbasis riset dan teknologi terkini.
            </p>
            <div class="products">
                <div class="card scroll-animate">
                    <span class="badge badge-blue">🌡️ IoT & Wearable Technology</span>
                    <h3>Child Care — Smart Shoe Monitoring</h3>
                    <p class="muted">
                        Teknologi terdepan dalam satu sepatu. Pantau kesehatan dan keamanan anak Anda secara real-time
                        melalui sensor cerdas yang terintegrasi langsung dengan aplikasi mobile. Solusi lengkap untuk
                        orang tua yang ingin memberikan perlindungan terbaik tanpa mengganggu aktivitas anak.
                    </p>
                    <ul class="features">
                        <li>Monitoring real-time: detak jantung, suhu tubuh, dan kelembapan</li>
                        <li>Sistem deteksi kecemasan berbasis AI dengan notifikasi instan</li>
                        <li>Pelacakan lokasi GPS/LBS yang akurat dan aman</li>
                        <li>Sensor canggih terintegrasi dalam sepatu</li>
                        <li>Sinkronisasi data ke aplikasi Android secara otomatis</li>
                        <li>Dashboard analitik untuk tracking tren kesehatan</li>
                    </ul>
                    <div class="cta">
                        <a class="btn btn-dark" href="{{ url('/child-care') }}">Pelajari Lebih Lanjut</a>
                        <a class="btn btn-outline" href="#">Download di Play Store</a>
                    </div>
                </div>
                <div class="card scroll-animate">
                    <span class="badge badge-green">📚 Edukasi & Gamifikasi</span>
                    <h3>Sipintar — Platform Edukasi Nutrisi Interaktif</h3>
                    <p class="muted">
                        Transformasi cara siswa belajar tentang nutrisi melalui gamifikasi yang menyenangkan.
                        Platform komprehensif yang membantu sekolah membangun budaya jajanan sehat dengan pendekatan
                        data-driven dan engagement tinggi.
                    </p>
                    <ul class="features">
                        <li>Database lengkap jajanan dengan informasi nutrisi akurat</li>
                        <li>Sistem gamifikasi untuk meningkatkan engagement siswa</li>
                        <li>Personal tracking konsumsi makanan harian</li>
                        <li>Fitur favorites dan history untuk pembelajaran personal</li>
                        <li>Konten edukasi nutrisi yang mudah dipahami</li>
                        <li>Akses tanpa login untuk browsing informasi nutrisi</li>
                    </ul>
                    <div class="cta">
                        <a class="btn btn-dark" href="{{ url('/sipintar') }}">Jelajahi Sipintar</a>
                        <a class="btn btn-outline" href="#">Download Aplikasi</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <section class="section" id="solutions" style="background: #f8f9fa;">
        <div class="container">
            <h2 class="scroll-animate">Solusi untuk Setiap Kebutuhan</h2>
            <p class="lead scroll-animate" style="margin-top: 12px;">
                Produk amhriset dirancang khusus untuk memenuhi kebutuhan spesifik berbagai pihak—dari orang tua yang
                peduli keamanan anak hingga institusi pendidikan yang ingin membangun program kesehatan berbasis data.
                Setiap solusi dibuat dengan pendekatan holistik dan teknologi terdepan.
            </p>
            <div class="grid-2" style="margin-top: 40px;">
                <div class="card scroll-animate">
                    <h3>👨‍👩‍👧‍👦 Untuk Orang Tua</h3>
                    <p style="margin-bottom: 12px; color: #64748b;">
                        Ket tenangan pikiran melalui teknologi yang terpercaya. Pantau dan lindungi anak Anda dengan
                        solusi yang mudah digunakan namun canggih.
                    </p>
                    <ul class="list-check">
                        <li>Monitoring kesehatan anak secara real-time 24/7</li>
                        <li>Notifikasi instan untuk kondisi tidak normal</li>
                        <li>Riwayat kesehatan dan tren analitik yang komprehensif</li>
                        <li>Akses mudah melalui aplikasi mobile yang user-friendly</li>
                        <li>Privasi data yang terjamin dengan standar GDPR/CCPA</li>
                    </ul>
                </div>
                <div class="card scroll-animate">
                    <h3>🏫 Untuk Sekolah & Institusi Pendidikan</h3>
                    <p style="margin-bottom: 12px; color: #64748b;">
                        Bangun program kesehatan dan nutrisi yang efektif dengan data yang terukur dan engagement tinggi
                        dari siswa.
                    </p>
                    <ul class="list-check">
                        <li>Kampanye jajanan sehat berbasis data dan analytics</li>
                        <li>Program gamifikasi untuk meningkatkan partisipasi siswa</li>
                        <li>Laporan konsumsi dan engagement yang detail</li>
                        <li>Dashboard admin untuk monitoring program</li>
                        <li>Integrasi mudah dengan sistem sekolah yang ada</li>
                    </ul>
                </div>
            </div>
            <div class="card scroll-animate" style="margin-top: 30px;">
                <h3>🏛️ Untuk Dinas Pendidikan & Komunitas</h3>
                <p style="margin-bottom: 12px; color: #64748b;">
                    Skalakan inisiatif kesehatan anak dan edukasi nutrisi ke level regional dengan platform yang
                    dapat diandalkan dan terukur.
                </p>
                <ul class="list-check">
                    <li>Implementasi program kesehatan anak skala besar</li>
                    <li>Inisiatif edukasi nutrisi yang terstruktur dan berkelanjutan</li>
                    <li>Pelatihan dan pendampingan implementasi untuk staf</li>
                    <li>Evaluasi program berbasis metrik dan KPI yang jelas</li>
                    <li>Dukungan teknis dan konsultasi dari tim ahli</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section" id="about">
        <div class="container grid-2">
            <div class="scroll-animate">
                <h2>Tentang amhriset</h2>
                <p class="lead">
                    Kami adalah tim yang berkomitmen untuk menghadirkan solusi teknologi yang benar-benar berdampak.
                    Dengan fokus pada riset mendalam dan pengembangan produk yang berpusat pada pengguna, kami membangun
                    ekosistem teknologi yang mendukung keluarga dan pendidikan dengan cara yang berkelanjutan dan etis.
                </p>
                <ul class="list-check" style="margin-top: 24px;">
                    <li><strong>Keamanan & Privasi Data</strong> sebagai standar fundamental dalam setiap produk</li>
                    <li><strong>Desain Inklusif</strong> yang dapat diakses oleh semua kalangan pengguna</li>
                    <li><strong>Kolaborasi Aktif</strong> dengan sekolah, orang tua, dan komunitas</li>
                    <li><strong>Pendekatan Berbasis Riset</strong> untuk memastikan efektivitas solusi</li>
                    <li><strong>Komitmen Berkelanjutan</strong> terhadap perbaikan dan inovasi terus-menerus</li>
                </ul>
            </div>
            <div class="card scroll-animate">
                <h3>Keunggulan Teknologi Kami</h3>
                <ul class="features">
                    <li><strong>Integrasi IoT & Mobile:</strong> Seamless connection antara perangkat hardware dan
                        software</li>
                    <li><strong>Advanced Analytics:</strong> Insight-driven dengan pelaporan yang actionable</li>
                    <li><strong>Scalable Architecture:</strong> Dapat berkembang sesuai kebutuhan institusi</li>
                    <li><strong>Real-time Processing:</strong> Data dan notifikasi yang selalu up-to-date</li>
                    <li><strong>Cloud Infrastructure:</strong> Reliable dan secure dengan uptime tinggi</li>
                    <li><strong>User Experience:</strong> Interface yang intuitif dan mudah digunakan</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section" id="testimonials" style="background: #f8f9fa;">
        <div class="container">
            <h2 class="scroll-animate">Apa Kata Pengguna Kami</h2>
            <div class="grid-2" style="margin-top: 30px;">
                <div class="card scroll-animate">
                    <p class="muted" style="font-style: italic; font-size: 1.05rem; line-height: 1.8;">
                        "Sebagai orang tua yang bekerja, Child Care memberikan saya ketenangan yang luar biasa.
                        Saya bisa memantau kesehatan anak saya kapan saja melalui aplikasi, dan sistem notifikasinya
                        sangat responsif. Ini benar-benar mengubah cara saya menjaga keamanan anak."
                    </p>
                    <p style="margin-top: 16px;">
                        <strong>— Ibu Sarah, Orang Tua Siswa</strong><br>
                        <span style="color: #64748b; font-size: 0.9rem;">Pengguna Child Care</span>
                    </p>
                </div>
                <div class="card scroll-animate">
                    <p class="muted" style="font-style: italic; font-size: 1.05rem; line-height: 1.8;">
                        "Sipintar telah membantu sekolah kami membangun program jajanan sehat yang efektif. Siswa
                        sangat antusias dengan fitur gamifikasi, dan kami bisa melihat peningkatan kesadaran nutrisi
                        secara signifikan. Dashboard analytics-nya sangat membantu untuk evaluasi program."
                    </p>
                    <p style="margin-top: 16px;">
                        <strong>— Pak Budi, Kepala Sekolah</strong><br>
                        <span style="color: #64748b; font-size: 0.9rem;">Mitra Sipintar</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="cta"
        style="background: linear-gradient(135deg, #111827 0%, #1f2937 100%); color: white;">
        <div class="container" style="text-align:center">
            <h2 style="color: white; margin-bottom: 20px;">Siap Memulai Perjalanan Bersama Kami?</h2>
            <p class="lead" style="margin:0 auto; color: rgba(255,255,255,0.9);">
                Mari kita diskusikan bagaimana solusi amhriset dapat membantu kebutuhan Anda. Tim kami siap memberikan
                demo produk, menjalankan pilot project di sekolah Anda, atau membangun kemitraan program kesehatan
                anak dan edukasi nutrisi yang berkelanjutan.
            </p>
            <div class="hero-cta" style="justify-content:center; margin-top: 30px;">
                <a class="btn btn-primary" href="mailto:contact@amhriset.com"
                    style="background: white; color: #111;">Hubungi Tim Kami</a>
                <a class="btn btn-outline" href="#products"
                    style="border-color: rgba(255,255,255,0.3); color: white;">Jelajahi Produk</a>
            </div>
        </div>
    </section>

    <section class="section" id="contact" style="background: #fff;">
        <div class="container">
            <h2 class="scroll-animate">Mari Berkolaborasi</h2>
            <p class="lead scroll-animate" style="margin-top: 12px;">
                Kami senang mendengar dari Anda. Apakah Anda ingin mengetahui lebih lanjut tentang produk kami,
                menjadwalkan demo, atau membahas peluang kolaborasi? Tim kami siap membantu.
            </p>
            <div class="cta" style="margin-top: 30px;">
                <a class="btn btn-primary" href="mailto:contact@amhriset.com">Kirim Email</a>
                <a class="btn btn-outline" href="#products">Pelajari Produk</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} amhriset.com - Inovasi Teknologi untuk Keluarga & Pendidikan yang Lebih Baik</p>
            <p style="margin-top: 8px; font-size: 0.85rem;">
                <a href="/privacy-policy" style="color: #6b7280; text-decoration: none; margin: 0 8px;">Privacy
                    Policy</a>
                <span>•</span>
                <a href="/terms-conditions" style="color: #6b7280; text-decoration: none; margin: 0 8px;">Terms &
                    Conditions</a>
            </p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        // Observe all scroll-animate elements
        document.querySelectorAll('.scroll-animate').forEach(el => {
            observer.observe(el);
        });

        // Header scroll effect
        let lastScroll = 0;
        const header = document.querySelector('.header');
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                header.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
            } else {
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.05)';
            }
            
            lastScroll = currentScroll;
        });

        // Counter animation for stats
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target + (target >= 1000 ? '+' : '') + (target === 98 ? '%' : '');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current) + (target >= 1000 ? '+' : '') + (target === 98 ? '%' : '');
                }
            }, 30);
        }

        // Trigger counter animation when stats section is visible
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-item h3');
                    const targets = [1000, 50, 24, 98];
                    statNumbers.forEach((stat, index) => {
                        const target = targets[index];
                        stat.textContent = '0';
                        setTimeout(() => animateCounter(stat, target), index * 200);
                    });
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }
    </script>
</body>

</html>