<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description"
        content="Sipintar - Aplikasi edukasi nutrisi untuk belajar dan tracking konsumsi makanan dengan informasi nutrisi lengkap dan akurat.">
    <meta name="keywords"
        content="nutrisi, edukasi, makanan, kesehatan, gizi, tracking, konsumsi, diet, sehat, sipintar">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Sipintar - Edukasi Nutrisi">
    <meta property="og:description"
        content="Aplikasi edukasi nutrisi untuk belajar dan tracking konsumsi makanan dengan informasi nutrisi lengkap dan akurat.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/sipintar') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logosipintar.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.svg') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #667eea;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #667eea;
        }

        /* Hero Section */
        .hero {
            padding: 120px 0 80px;
            text-align: center;
            color: white;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary {
            background: #ff6b6b;
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        .btn-primary:hover {
            background: #ff5252;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: white;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            padding: 60px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* How It Works */
        .how-it-works {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .step {
            text-align: center;
            padding: 2rem;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1rem;
        }

        .step h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .step p {
            color: #666;
            line-height: 1.6;
        }

        /* Download Section */
        .download {
            padding: 80px 0;
            background: white;
            text-align: center;
        }

        .download-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .download h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .download p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .store-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .store-btn {
            display: inline-block;
            padding: 15px 25px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .store-btn:hover {
            background: #555;
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            background: #333;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer p {
            color: #999;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .nav-links {
                display: none;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .steps {
                grid-template-columns: 1fr;
            }

            .store-buttons {
                flex-direction: column;
                align-items: center;
            }

            .store-btn {
                width: 100%;
                max-width: 250px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Scroll indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .scroll-indicator::after {
            content: '↓';
            display: block;
            font-size: 1.5rem;
            margin-top: 5px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="#" class="logo"> <img src="{{ asset('images/logosipintar.png') }}" alt="Sipintar" style="width: 30px; height: 30px;"> Sipintar</a>
                <ul class="nav-links">
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#how-it-works">Cara Kerja</a></li>
                    <li><a href="#download">Download</a></li>
                    <li><a href="/privacy-policy">Privacy</a></li>
                    <li><a href="/terms-conditions">Terms</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="fade-in-up">Sipintar</h1>
            <p class="fade-in-up">Aplikasi Edukasi Nutrisi Terdepan</p>
            <p class="fade-in-up">Pelajari informasi nutrisi makanan dan pantau konsumsi harian dengan mudah. Mulai
                perjalanan hidup sehat Anda sekarang!</p>
            <div class="cta-buttons fade-in-up">
                <a href="#download" class="btn btn-primary">Download Sekarang</a>
                <a href="#features" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
            </div>
            <div class="scroll-indicator">Scroll untuk melihat lebih banyak</div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🍽️</div>
                    <h3>Browse Menu Makanan</h3>
                    <p>Jelajahi ribuan menu makanan dengan informasi nutrisi lengkap. Tidak perlu login untuk melihat
                        konten!</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Tracking Konsumsi</h3>
                    <p>Pantau makanan yang Anda konsumsi setiap hari dengan sistem tracking yang mudah dan akurat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">❤️</div>
                    <h3>Favorites & History</h3>
                    <p>Simpan makanan favorit dan lihat riwayat konsumsi untuk membantu pola makan yang lebih baik.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📚</div>
                    <h3>Edukasi Nutrisi</h3>
                    <p>Pelajari tips makan sehat, panduan gizi seimbang, dan konten edukatif untuk semua usia.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3>Pencarian Cerdas</h3>
                    <p>Cari makanan berdasarkan kategori, nama, atau kandungan nutrisi dengan sistem pencarian yang
                        canggih.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h3>Privacy First</h3>
                    <p>Data Anda aman dan terlindungi. Kontrol penuh atas data pribadi dengan standar GDPR/CCPA.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>1000+</h3>
                    <p>Menu Makanan</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Kategori Makanan</p>
                </div>
                <div class="stat-item">
                    <h3>15+</h3>
                    <p>Informasi Nutrisi</p>
                </div>
                <div class="stat-item">
                    <h3>24/7</h3>
                    <p>Akses Gratis</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <h2 class="section-title">Cara Kerja Sipintar</h2>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Download & Install</h3>
                    <p>Download aplikasi Sipintar dari Play Store atau App Store secara gratis</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Browse Tanpa Login</h3>
                    <p>Jelajahi menu makanan dan informasi nutrisi tanpa perlu membuat akun</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Login untuk Fitur Personal</h3>
                    <p>Buat akun untuk menyimpan favorites, tracking konsumsi, dan fitur personal lainnya</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Mulai Hidup Sehat</h3>
                    <p>Pantau konsumsi harian dan pelajari nutrisi untuk hidup yang lebih sehat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section id="download" class="download">
        <div class="container">
            <div class="download-content">
                <h2>Siap Memulai Perjalanan Sehat?</h2>
                <p>Download Sipintar sekarang dan mulai belajar tentang nutrisi makanan dengan cara yang menyenangkan!
                </p>
                <div class="store-buttons">
                    <a href="#" class="store-btn">📱 Google Play Store</a>
                    <a href="#" class="store-btn">🍎 Apple App Store</a>
                </div>
                <p style="margin-top: 2rem; font-size: 0.9rem; color: #999;">
                    Gratis • Tanpa Iklan • Privacy-First
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-links">
                <a href="/privacy-policy">Privacy Policy</a>
                <a href="/terms-conditions">Terms & Conditions</a>
                <a href="mailto:support@sipintar.com">Support</a>
                <a href="mailto:contact@sipintar.com">Contact</a>
            </div>
            <p>&copy; 2024 Sipintar. All rights reserved. | Edukasi Nutrisi untuk Semua</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
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

        // Add scroll effect to header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Observe steps
        document.querySelectorAll('.step').forEach(step => {
            step.style.opacity = '0';
            step.style.transform = 'translateY(30px)';
            step.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(step);
        });
    </script>
</body>

</html>