<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#4f46e5" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0b1020" media="(prefers-color-scheme: dark)">

    <title>@yield('title', $title ?? 'amhriset.com')</title>
    <meta name="description"
        content="@yield('description', 'amhriset.com — riset dan produk teknologi untuk keluarga dan pendidikan.')">

    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="amhriset.com">
    <meta property="og:title" content="@yield('title', $title ?? 'amhriset.com')">
    <meta property="og:description"
        content="@yield('description', 'amhriset.com — riset dan produk teknologi untuk keluarga dan pendidikan.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    {{-- Version the stylesheet by its mtime. Without this the URL never
         changes, so browsers keep serving a cached copy and CSS edits appear
         not to have taken effect until a manual hard refresh. --}}
    @php
        $amhCssPath = public_path('css/amh.css');
        $amhCssUrl = asset('css/amh.css');
        if (is_file($amhCssPath)) {
            $amhCssUrl .= '?v=' . filemtime($amhCssPath);
        }
    @endphp
    <link rel="stylesheet" href="{{ $amhCssUrl }}">

    @stack('head')
</head>

<body>
    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    <header class="nav" id="siteNav">
        <div class="container">
            <div class="nav-inner">
                <a href="{{ url('/') }}" class="brand">
                    <span class="brand-mark" aria-hidden="true">am</span>
                    <span>amhriset<span class="brand-sub">.com</span></span>
                </a>

                <button class="nav-toggle" type="button" id="navToggle" aria-expanded="false" aria-controls="navMenu"
                    aria-label="Buka menu navigasi">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" aria-hidden="true">
                        <path d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>

                <div class="nav-menu" id="navMenu">
                    <nav class="nav-links" aria-label="Navigasi utama">
                        @section('nav_links')
                            <a href="{{ url('/#produk') }}">Produk</a>
                            <a href="{{ url('/child-care') }}">Child Care</a>
                            <a href="{{ url('/sipintar') }}">Sipintar</a>
                            <a href="{{ url('/#tentang') }}">Tentang</a>
                        @show
                    </nav>
                    <div class="nav-actions">
                        @section('nav_actions')
                            <a class="btn btn-primary btn-sm" href="mailto:contact@amhriset.com">Hubungi Kami</a>
                        @show
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <a href="{{ url('/') }}" class="brand">
                        <span class="brand-mark" aria-hidden="true">am</span>
                        <span>amhriset<span class="brand-sub">.com</span></span>
                    </a>
                    <p>Riset dan produk teknologi untuk keluarga dan pendidikan — monitoring kesehatan anak berbasis
                        IoT dan edukasi nutrisi yang interaktif.</p>
                </div>

                <div>
                    <h4>Produk</h4>
                    <div class="footer-links">
                        <a href="{{ url('/child-care') }}">Child Care</a>
                        <a href="{{ url('/sipintar') }}">Sipintar</a>
                    </div>
                </div>

                <div>
                    <h4>Legal</h4>
                    <div class="footer-links">
                        <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                        <a href="{{ url('/terms-conditions') }}">Terms &amp; Conditions</a>
                        <a href="{{ url('/tnc-child-care') }}">Kebijakan Child Care</a>
                        <a href="{{ url('/delete-account') }}">Hapus Akun</a>
                    </div>
                </div>

                <div>
                    <h4>Kontak</h4>
                    <div class="footer-links">
                        <a href="mailto:contact@amhriset.com">contact@amhriset.com</a>
                        <a href="mailto:support@amhriset.com">support@amhriset.com</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} amhriset.com. Seluruh hak cipta dilindungi.</span>
                <span>Dibangun dengan pendekatan berbasis riset.</span>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            var nav = document.getElementById('siteNav');
            var onScroll = function () {
                nav.dataset.scrolled = window.scrollY > 8 ? 'true' : 'false';
            };
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });

            var toggle = document.getElementById('navToggle');
            var menu = document.getElementById('navMenu');
            toggle.addEventListener('click', function () {
                var open = menu.dataset.open === 'true';
                menu.dataset.open = String(!open);
                toggle.setAttribute('aria-expanded', String(!open));
            });
            menu.addEventListener('click', function (e) {
                if (e.target.closest('a')) {
                    menu.dataset.open = 'false';
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });

            var revealables = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window)) {
                revealables.forEach(function (el) { el.classList.add('is-visible'); });
            } else {
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) return;
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    });
                }, { threshold: 0.12, rootMargin: '0px 0px -40px' });

                revealables.forEach(function (el, i) {
                    el.style.transitionDelay = Math.min(i % 4, 3) * 70 + 'ms';
                    io.observe(el);
                });
            }

            var counters = document.querySelectorAll('[data-count]');
            if (counters.length && 'IntersectionObserver' in window) {
                var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                var co = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) return;
                        var el = entry.target;
                        co.unobserve(el);

                        var target = parseFloat(el.dataset.count);
                        var prefix = el.dataset.prefix || '';
                        var suffix = el.dataset.suffix || '';
                        if (reduce || !isFinite(target)) {
                            el.textContent = prefix + target + suffix;
                            return;
                        }

                        var start = performance.now();
                        var duration = 1100;
                        var tick = function (now) {
                            var p = Math.min((now - start) / duration, 1);
                            var eased = 1 - Math.pow(1 - p, 3);
                            el.textContent = prefix + Math.round(target * eased) + suffix;
                            if (p < 1) requestAnimationFrame(tick);
                        };
                        el.textContent = prefix + '0' + suffix;
                        requestAnimationFrame(tick);
                    });
                }, { threshold: 0.5 });
                counters.forEach(function (el) { co.observe(el); });
            }

            var tocLinks = document.querySelectorAll('.toc a[href^="#"]');
            if (tocLinks.length && 'IntersectionObserver' in window) {
                var map = {};
                var headings = [];
                tocLinks.forEach(function (link) {
                    var target = document.getElementById(link.getAttribute('href').slice(1));
                    if (!target) return;
                    map[target.id] = link;
                    headings.push(target);
                });
                var to = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) return;
                        tocLinks.forEach(function (l) { l.removeAttribute('aria-current'); });
                        map[entry.target.id].setAttribute('aria-current', 'true');
                    });
                }, { rootMargin: '-80px 0px -70% 0px' });
                headings.forEach(function (h) { to.observe(h); });
            }
        })();
    </script>

    @stack('scripts')
</body>

</html>
