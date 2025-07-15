<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KelasPrivat.id - Les Privat Online Terbaik')</title>
    <meta name="description" content="@yield('meta_description', 'Les privat online terbaik dengan pengajar berpengalaman. Program les privat SD, SMP, SMA dengan metode pembelajaran interaktif.')">
    <meta name="keywords" content="@yield('meta_keywords', 'les privat, les privat online, bimbel online, les privat SD, les privat SMP, les privat SMA')">
    @section('og_title', 'Judul untuk social media')
    @section('og_description', 'Deskripsi untuk social media')
    @section('og_image', asset('images/og-image.jpg'))
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/svg+xml" href="/favicon-32x32.svg" sizes="32x32">
    <link rel="icon" type="image/svg+xml" href="/favicon-16x16.svg" sizes="16x16">
    <link rel="apple-touch-icon" href="/apple-touch-icon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2563EB">
    <meta name="msapplication-TileColor" content="#2563EB">
    
    <!-- PWA Meta Tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="KelasPrivat">
    <meta name="msapplication-config" content="/browserconfig.xml">
    
    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/assets/img/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/icon-180x180.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/assets/img/icon-167x167.png">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            important: false,
            prefix: 'tw-',
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        /* Reset Tailwind untuk menghindari konflik dengan Bootstrap */
        .container {
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        @media (min-width: 640px) {
            .container {
                max-width: 640px;
            }
        }
        
        @media (min-width: 768px) {
            .container {
                max-width: 768px;
            }
        }
        
        @media (min-width: 1024px) {
            .container {
                max-width: 1024px;
            }
        }
        
        @media (min-width: 1280px) {
            .container {
                max-width: 1280px;
            }
        }
        
        /* Override Bootstrap untuk blog pages */
        .blog-page .container {
            max-width: 100%;
        }
        
        .blog-page .row {
            margin-left: 0;
            margin-right: 0;
        }
        
        .blog-page .col,
        .blog-page .col-md,
        .blog-page .col-lg {
            padding-left: 0;
            padding-right: 0;
        }

        /* Fix navbar visibility issues */
        .navbar {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 1030 !important;
            width: 100% !important;
            min-height: 70px !important;
        }
        
        .navbar-brand {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .btn {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .navbar-nav {
            display: flex !important;
            flex-direction: row !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .navbar-nav .nav-item {
            display: block !important;
            margin: 0 !important;
        }
        
        .navbar-nav .nav-link {
            display: block !important;
            padding: 0.5rem 1rem !important;
            text-decoration: none !important;
            color: inherit !important;
        }
        
        .navbar-collapse {
            display: flex !important;
            flex-basis: 100% !important;
            flex-grow: 1 !important;
            align-items: center !important;
        }
        
        .navbar-toggler {
            display: none !important;
        }
        
        @media (max-width: 991.98px) {
            .navbar-toggler {
                display: block !important;
            }
            
            .navbar-collapse {
                display: none !important;
            }
            
            .navbar-collapse.show {
                display: flex !important;
                flex-direction: column !important;
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                right: 0 !important;
                background: white !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
                padding: 1rem !important;
            }
            
            .navbar-nav {
                flex-direction: column !important;
                width: 100% !important;
            }
            
            .navbar-nav .nav-item {
                width: 100% !important;
                margin-bottom: 0.5rem !important;
            }
        }

        
        /* Floating Orbs */
        .bg-gradient-primary .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            animation: floatOrb 15s ease-in-out infinite;
        }

        .bg-gradient-primary .floating-orb:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -150px;
            animation-delay: 0s;
        }

        .bg-gradient-primary .floating-orb:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -100px;
            right: 50px;
            animation-delay: -5s;
        }

        .bg-gradient-primary .floating-orb:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            left: -75px;
            animation-delay: -10s;
        }   

        /* Enhanced Animations */
        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        @keyframes floatOrb {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            100% { transform: translateY(0) rotate(360deg); }
        }

        :root {
            /* Warna yang lebih profesional dan modern */
            --primary-color: #2563EB;
            --primary-dark: #1D4ED8;
            --primary-light: #60A5FA;
            --secondary-color: #0F172A;
            --accent-color: #3B82F6;
            --success-color: #059669;
            --warning-color: #D97706;
            --danger-color: #DC2626;
            --dark-color: #1E293B;
            --light-color: #F8FAFC;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            /* Spacing system yang konsisten */
            --spacing-1: 0.25rem;
            --spacing-2: 0.5rem;
            --spacing-3: 0.75rem;
            --spacing-4: 1rem;
            --spacing-5: 1.25rem;
            --spacing-6: 1.5rem;
            --spacing-8: 2rem;
            --spacing-10: 2.5rem;
            --spacing-12: 3rem;
            --spacing-16: 4rem;
            --spacing-20: 5rem;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark-color);
            background-color: var(--light-color);
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
            padding: 1rem 0 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1030 !important;
        }
        
        .navbar.scrolled {
            padding: 0.5rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark-color);
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(37, 99, 235, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 5rem 0 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s ease;
            margin: 0 0.5rem;
        }
        
        .social-icon:hover {
            background: var(--primary-color);
            transform: translateY(-3px) rotate(360deg);
        }
        
        .card {
            border: none;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
                        0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                        0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 1rem;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .feature-icon:hover {
            transform: rotate(10deg) scale(1.1);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
        
        /* Gradien modern */
        .gradient-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        }
        
        .gradient-dark {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--dark-color) 100%);
        }
        
        /* Typography system yang lebih profesional */
        h1, .h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        
        h2, .h2 {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: -0.01em;
        }
        
        h3, .h3 {
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.4;
        }
        
        h4, .h4 {
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1.5;
        }
        
        p, .p {
            font-size: 1.125rem;
            line-height: 1.7;
            color: var(--gray-600);
        }
        
        .lead {
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.6;
            color: var(--gray-700);
        }
        
        /* Container yang lebih responsif */
        .container {
            max-width: 1280px;
            padding-left: var(--spacing-4);
            padding-right: var(--spacing-4);
        }
        
        @media (min-width: 640px) {
            .container {
                padding-left: var(--spacing-6);
                padding-right: var(--spacing-6);
            }
        }
        
        @media (min-width: 1024px) {
            .container {
                padding-left: var(--spacing-8);
                padding-right: var(--spacing-8);
            }
        }
        
        /* Animasi yang lebih halus */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .slide-up {
            animation: slideUp 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        /* Hover effects yang lebih menarik */
        .hover-lift {
            transition: transform 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
        }
        
        .hover-glow {
            transition: box-shadow 0.3s ease;
        }
        
        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(37, 99, 235, 0.3);
        }
        
        /* Input fields yang lebih modern */
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        
        /* Custom select yang lebih menarik */
        .select-wrapper {
            position: relative;
        }
        
        .select-wrapper::after {
            content: '';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid var(--gray-500);
            pointer-events: none;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="display: flex !important; visibility: visible !important; opacity: 1 !important;">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-graduation-cap me-2"></i>KelasPrivat.id
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="display: flex !important;">
                <ul class="navbar-nav ms-auto" style="display: flex !important; flex-direction: row !important;">
                    <li class="nav-item" style="display: block !important;">
                        <a class="nav-link" href="/" style="display: block !important;">Beranda</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="/les-privat">Les Privat</a>
                    </li> -->
                    <li class="nav-item" style="display: block !important;">
                        <a class="nav-link" href="/bank-soal" style="display: block !important;">Bank Soal</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="/materi">Materi</a>
                    </li> --}}
                    <li class="nav-item" style="display: block !important;">
                        <a class="nav-link" href="/news" style="display: block !important;">Berita</a>
                    </li>
                </ul>
                <div class="ms-lg-3" style="display: flex !important; align-items: center !important;">
                    @auth
                        <div class="dropdown" style="display: block !important;">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" style="display: inline-block !important;">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/profile"><i class="fas fa-user me-2"></i>Profil</a></li>
                                <li><a class="dropdown-item" href="/dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                @if(auth()->user()->role === 'owner')
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.blog.index') }}"><i class="fas fa-blog me-2"></i>Kelola Blog</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="/login" class="btn btn-outline-primary me-2" style="display: inline-block !important;">Masuk</a>
                        <a href="/register" class="btn btn-primary" style="display: inline-block !important;">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-5" style="padding-top: 100px !important;">
        @yield('content')
        
    </main>

    <!-- Footer -->
    <footer class="footer gradient-dark text-white py-5" id="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">KelasPrivat.id</h5>
                    <p class="footer-link">Platform les privat online terbaik di Indonesia dengan pengajar berpengalaman dan metode pembelajaran interaktif.</p>
                    <div class="mt-4 d-flex gap-2">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Program</h6>
                    <ul class="list-unstyled">
                        <li><a href="/les-privat/sd" class="footer-link">Les Privat SD</a></li>
                        <li><a href="/les-privat/smp" class="footer-link">Les Privat SMP</a></li>
                        <li><a href="/les-privat/sma" class="footer-link">Les Privat SMA</a></li>
                        <li><a href="/bank-soal" class="footer-link">Bank Soal</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Perusahaan</h6>
                    <ul class="list-unstyled">
                        <li><a href="/about" class="footer-link">Tentang Kami</a></li>
                        <li><a href="/careers" class="footer-link">Karir</a></li>
                        <li><a href="/contact" class="footer-link">Kontak</a></li>
                        <li><a href="/blog" class="footer-link">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Kontak Kami</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2 footer-link"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Griya Family 4, Kab. Bekasi</li>
                        <li class="mb-2"><a href="https://wa.me/6281211006445" class="footer-link"><i class="fas fa-phone me-2 text-primary"></i>+62 812 1100 6445</a></li>
                        <li class="mb-2 footer-link"><i class="fas fa-envelope me-2 text-primary"></i>info@kelasprivat.id</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 footer-link">&copy; 2024 KelasPrivat.id. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="/privacy" class="footer-link me-3">Kebijakan Privasi</a>
                    <a href="/terms" class="footer-link">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Structured Data -->
    @include('partials.structured-data')
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom Scripts -->
    @stack('scripts')
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Ensure navbar is visible
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            const navbarNav = document.querySelector('.navbar-collapse');
            const navbarBrand = document.querySelector('.navbar-brand');
            const buttons = document.querySelectorAll('.btn');
            
            if (navbar) {
                navbar.style.display = 'flex';
                navbar.style.visibility = 'visible';
                navbar.style.opacity = '1';
            }
            
            if (navbarNav) {
                navbarNav.style.display = 'flex';
            }
            
            if (navbarBrand) {
                navbarBrand.style.display = 'inline-block';
                navbarBrand.style.visibility = 'visible';
            }
            
            buttons.forEach(button => {
                button.style.display = 'inline-block';
                button.style.visibility = 'visible';
            });
        });
        
        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
        
        // PWA Install Prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button if available
            const installButton = document.getElementById('install-button');
            if (installButton) {
                installButton.style.display = 'block';
                installButton.addEventListener('click', () => {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the install prompt');
                        } else {
                            console.log('User dismissed the install prompt');
                        }
                        deferredPrompt = null;
                        installButton.style.display = 'none';
                    });
                });
            }
        });
    </script>
</body>
</html>
