<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AUTOBILI LTD - Vehicle Auction Data</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,500,0,0&icon_names=check_circle" />
    <link rel="icon" type="image/x-icon" href="{{ asset('public/theme/fav.png') }}" />

    {{-- <link rel="stylesheet" href="{{asset('/public/theme/styles.css')}}" /> --}}
    <!-- Hugeicons Free Icon Font -->
    <link rel="stylesheet" href="https://cdn.hugeicons.com/1.0.0/hugeicons.css">

    <link rel="stylesheet" href="{{ asset('public/theme/css/toastr.min.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('public/theme/assets/web/css/loader.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/theme/assets/web/css/home.css') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Tailwind Dark Mode Configuration -->
    <script>
        tailwind.config = {
            darkMode: "class", // Enable class-based dark mode
        };
    </script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        body {
            font-family: "Inter", sans-serif !important;
        }

        /* Optional: Improve backdrop rendering */
        @supports ((-webkit-backdrop-filter: blur(0)) or (backdrop-filter: blur(0))) {
            #siteNav.backdrop-blur-xl {
                -webkit-backdrop-filter: blur(16px);
                backdrop-filter: blur(16px);
            }
        }

        #themeToggle span {
            font-size: 28px
        }
    </style>

    @yield('css')
</head>

<body>
    @if (!View::hasSection('hideNavbar'))
        @include('web.partial.nav')
    @endif
    @yield('content')

    @if (!View::hasSection('hideFooter'))
        <footer class="bg-[#071524] text-[#B2C0CE] px-8 md:px-16 lg:px-32 py-12">
            <div class="max-w-7xl mx-auto space-y-10">

                <!-- Top Section -->
                <div>
                    <h2 class="text-2xl font-semibold text-white">AUTOBOLI Ltd</h2>
                    <p class="mt-3 text-[#AAB8C5] max-w-3xl">
                        Helping dealers, exporters, and traders buy smarter with real-time auction data from across the
                        UK &
                        Japan.
                        Save money, reduce risk, and grow your automotive business — all in one platform.
                    </p>
                </div>

                <!-- Links Section -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 md:gap-12 text-sm">
                    <!-- Column 1 -->
                    <div>
                        <h3 class="text-white font-semibold mb-2">AutoBoli</h3>
                        <ul class="space-y-1">
                            <li><a href="{{ url('/about') }}" class="hover:text-white transition">about us</a></li>
                            <li><a href="#" class="hover:text-white transition">customer</a></li>
                            <li><a href="#" class="hover:text-white transition">community</a></li>
                            <li><a href="#" class="hover:text-white transition">Affiliate & Referrals</a></li>
                            <li><a href="#" class="hover:text-white transition">News</a></li>
                            <li><a href="#" class="hover:text-white transition">Brand</a></li>
                            <li><a href="#" class="hover:text-white transition">Bidding</a></li>
                            <li><a href="#" class="hover:text-white transition">Roadmap</a></li>
                        </ul>
                    </div>

                    <!-- Column 2 -->
                    <div>
                        <h3 class="text-white font-semibold mb-2">Learn</h3>
                        <ul class="space-y-1">
                            <li><a href="#" class="hover:text-white transition">Actions</a></li>
                            <li><a href="#" class="hover:text-white transition">Actions</a></li>
                            <li><a href="#" class="hover:text-white transition">Actions</a></li>
                            <li><a href="#" class="hover:text-white transition">Actions</a></li>
                            <li><a href="#" class="hover:text-white transition">Actions</a></li>
                        </ul>
                    </div>

                    <!-- Column 3 -->
                    <div>
                        <h3 class="text-white font-semibold mb-2">Resources</h3>
                        <ul class="space-y-1">
                            <li><a href="#" class="hover:text-white transition">Guidance</a></li>
                            <li><a href="#" class="hover:text-white transition">Explore</a></li>
                            <li><a href="#" class="hover:text-white transition">featuristic panels</a></li>
                            <li><a href="#" class="hover:text-white transition">blog</a></li>
                            <li><a href="#" class="hover:text-white transition">support</a></li>
                            <li><a href="#" class="hover:text-white transition">vin search</a></li>
                            <li><a href="#" class="hover:text-white transition">find auc</a></li>
                            <li><a href="#" class="hover:text-white transition">vehicle value</a></li>
                        </ul>
                    </div>

                    <!-- Column 4 -->
                    <div>
                        <h3 class="text-white font-semibold mb-2">Connect</h3>
                        <ul class="space-y-1">
                            <li><a href="#" class="hover:text-white transition">Facebook</a></li>
                            <li><a href="#" class="hover:text-white transition">Insta</a></li>
                            <li><a href="#" class="hover:text-white transition">Tiktok</a></li>
                            <li><a href="#" class="hover:text-white transition">X</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="border-t border-gray-700 pt-6 text-sm text-[#8C9BAB]">
                    <p>© AUTOBOLI Ltd 2025. All rights reserved.</p>
                    <p class="mt-2">Proudly built & hosted with secure infrastructure in the UK & EU.</p>
                </div>
            </div>
        </footer>
    @endif
</body>

<script src="{{ asset('/public/themeadmin/assets/js/jquery.js') }}"></script>
<script src="{{ asset('/public/theme/js/bootstrap.js') }}"></script>
<script src="{{ asset('/public/theme/app.js') }}"></script>
<script src="{{ asset('public/theme/js/toastr.min.js') }}"></script>

@yield('js')
<script>
    // 🌀 Loader hide logic
    window.addEventListener("load", () => {
        setTimeout(() => {
            const loader = document.getElementById("loader");
            if (loader) {
                loader.classList.add("opacity-0");
                setTimeout(() => {
                    loader.style.display = "none";
                }, 500);
            }
        }, 1500);
    });

    // 🧭 Simple button-controlled scroll for carousel
    (function() {
        const track = document.getElementById("resTrack");
        const prev = document.getElementById("resPrev");
        const next = document.getElementById("resNext");
        if (!track) return;

        function move(dir = 1) {
            const card = track.querySelector("article");
            if (!card) return;
            const gap = parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap) || 24;
            const delta = (card.getBoundingClientRect().width + gap) * dir;
            track.scrollBy({
                left: delta,
                behavior: "smooth"
            });
        }

        if (prev && next) {
            prev.addEventListener("click", () => move(-1));
            next.addEventListener("click", () => move(1));
        }

        // Keyboard navigation
        track.setAttribute("tabindex", "0");
        track.addEventListener("keydown", (e) => {
            if (e.key === "ArrowRight") move(1);
            if (e.key === "ArrowLeft") move(-1);
        });
    })();

    // 📈 Animated counters (stat-number and counter)
    (function() {
        const els = document.querySelectorAll(".stat-number, .counter");
        if (!els.length) return;

        function animate(el) {
            const target = +el.dataset.target || 0;
            const suffix = el.dataset.suffix || "";
            const dur = 1200;
            const start = performance.now();

            function tick(now) {
                const p = Math.min(1, (now - start) / dur);
                const eased = 1 - Math.pow(1 - p, 3);
                el.textContent = Math.floor(target * eased).toLocaleString() + suffix;
                if (p < 1) requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
        }

        const io = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((e) => {
                    if (e.isIntersecting) {
                        animate(e.target);
                        obs.unobserve(e.target);
                    }
                });
            }, {
                threshold: 0.4
            }
        );

        els.forEach((el) => io.observe(el));
    })();

    // 🧍 Sticky shadow on navbar
    (function() {
        const siteNav = document.getElementById("siteNav");
        if (!siteNav) return;

        function updateNavOnScroll() {
            const scrolled = window.scrollY > 8;
            siteNav.classList.toggle("shadow-sm", scrolled);
        }

        updateNavOnScroll();
        window.addEventListener("scroll", updateNavOnScroll, {
            passive: true
        });
    })();

    // --- GLOBAL THEME HANDLER (works across all pages & buttons) ---
    (function() {
        const HTML = document.documentElement;
        const TOGGLE_SELECTOR = '[data-theme-toggle]';
        const ICON_SELECTOR = '[data-theme-icon]';

        // Pick initial theme (localStorage > system preference > light)
        function getInitialTheme() {
            if (localStorage.theme) return localStorage.theme;
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        function applyTheme(theme) {
            const isDark = theme === 'dark';
            HTML.classList.toggle('dark', isDark);
            localStorage.theme = theme;

            // Update all icons (there can be multiple toggles on the page)
            document.querySelectorAll(ICON_SELECTOR).forEach((icon) => {
                // If you're using Material Symbols:
                if (icon.classList.contains('material-symbols-outlined')) {
                    icon.textContent = isDark ? 'dark_mode' : 'light_mode';
                }
                // If you're using Font Awesome:
                if (icon.classList.contains('fa')) {
                    icon.classList.toggle('fa-moon', !isDark);
                    icon.classList.toggle('fa-sun', isDark);
                }
            });
        }

        function toggleTheme() {
            applyTheme(HTML.classList.contains('dark') ? 'light' : 'dark');
        }

        // Init once on each page
        applyTheme(getInitialTheme());

        // Wire up any toggle buttons on the page (navbar, login header, etc.)
        function wireToggles() {
            document.querySelectorAll(TOGGLE_SELECTOR).forEach((btn) => {
                if (!btn.__wired) {
                    btn.addEventListener('click', toggleTheme);
                    btn.__wired = true;
                }
            });
        }

        // Wire on DOM ready (covers pages where navbar is hidden & custom header exists)
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', wireToggles);
        } else {
            wireToggles();
        }

        // Also re-wire if the DOM changes (optional safety)
        const mo = new MutationObserver(wireToggles);
        mo.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Sync across tabs
        window.addEventListener('storage', (e) => {
            if (e.key === 'theme' && e.newValue) applyTheme(e.newValue);
        });
    })();

    // 💨 Reveal animation for feature cards
    (function() {
        const cards = document.querySelectorAll("#features .feat-card");
        if (!cards.length) return;

        const io = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((e) => {
                    if (e.isIntersecting) {
                        e.target.classList.add("revealed");
                        obs.unobserve(e.target);
                    }
                });
            }, {
                threshold: 0.15
            }
        );
        cards.forEach((c) => io.observe(c));
    })();
</script>


</html>
