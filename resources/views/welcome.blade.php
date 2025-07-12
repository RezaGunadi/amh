<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kelas Privat</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #f8f9fa;
            }
            .navbar {
                background-color: #fff;
                box-shadow: 0 2px 4px rgba(0,0,0,.04);
            }
            .navbar-brand {
                font-weight: 600;
            }
            .card {
                border: none;
                box-shadow: 0 2px 4px rgba(0,0,0,.05);
                transition: transform 0.2s;
            }
            .card:hover {
                transform: translateY(-5px);
            }
            .feature-icon {
                width: 4rem;
                height: 4rem;
                border-radius: 0.75rem;
            }
            .footer {
                background-color: #fff;
                border-top: 1px solid #e5e7eb;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Kelas Privat
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item">
                                    <a href="{{ url('/home') }}" class="nav-link">Home</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link">Log in</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="text-center mb-5">
                        <h1 class="display-4 mb-4">Welcome to Kelas Privat</h1>
                        <p class="lead text-muted">Your trusted platform for online learning</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-primary bg-gradient text-white d-flex align-items-center justify-content-center">
                                            <i class="fas fa-book fa-2x"></i>
                                        </div>
                                        <h3 class="h5 mb-0 ms-3">Documentation</h3>
                                    </div>
                                    <p class="text-muted mb-0">
                                        Learn about our platform features and how to get started with your learning journey.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-primary bg-gradient text-white d-flex align-items-center justify-content-center">
                                            <i class="fas fa-video fa-2x"></i>
                                        </div>
                                        <h3 class="h5 mb-0 ms-3">Video Tutorials</h3>
                                    </div>
                                    <p class="text-muted mb-0">
                                        Watch our video tutorials to understand how to make the most of our platform.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-primary bg-gradient text-white d-flex align-items-center justify-content-center">
                                            <i class="fas fa-newspaper fa-2x"></i>
                                        </div>
                                        <h3 class="h5 mb-0 ms-3">Latest News</h3>
                                    </div>
                                    <p class="text-muted mb-0">
                                        Stay updated with the latest news and updates from our platform.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon bg-primary bg-gradient text-white d-flex align-items-center justify-content-center">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                        <h3 class="h5 mb-0 ms-3">Community</h3>
                                    </div>
                                    <p class="text-muted mb-0">
                                        Join our vibrant community of learners and educators.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer py-4 mt-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 text-center text-lg-start">
                        <p class="text-muted mb-0">
                            &copy; {{ date('Y') }} Kelas Privat. All rights reserved.
                        </p>
                    </div>
                    <div class="col-lg-6 text-center text-lg-end">
                        <div class="d-flex justify-content-center justify-content-lg-end gap-3">
                            <a href="#" class="text-muted text-decoration-none">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="#" class="text-muted text-decoration-none">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a href="#" class="text-muted text-decoration-none">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
