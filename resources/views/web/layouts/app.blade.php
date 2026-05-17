<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamic Title -->
    <title>@yield('title', 'Fleetshyp')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/fleetsheep1.png') }}">

    <!-- Meta -->
    <meta name="description" content="@yield('meta_description', 'Website Description')">
    <meta name="keywords" content="@yield('meta_keywords', 'keywords')">
    <!-- ... other meta tags ... -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... -->



    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    
    <!-- Extra CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')

    <!-- ✅ Critical CSS for Responsive Header -->
    <style>
        /* ===== HEADER STYLES ===== */
       #header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9999;
    background: transparent; /* ✅ Initially Transparent */
    box-shadow: none; /* ✅ Shadow initially hata diya taaki clean dikhe */
    padding: 12px 0;
    transition: all 0.3s ease;
    height: auto;
    min-height: 70px;
}

        #header.scrolled {
    padding: 8px 0;
    background: #ffffff; /* ✅ Hero ke baad Solid White */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

        #header .logo img {
            max-height: 50px;
            width: auto;
            transition: all 0.3s ease;
        }

        #header.scrolled .logo img {
            max-height: 45px;
        }

        /* ===== DESKTOP NAVIGATION ===== */
        .navmenu {
            display: flex;
            align-items: center;
        }

        .navmenu ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 5px;
        }

        .navmenu ul li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
            border-radius: 6px;
            white-space: nowrap;
        }

        .navmenu ul li a:hover,
        .navmenu ul li a.active {
            color: #DABB55;
            background: rgba(218, 181, 85, 0.1);
        }

        /* Desktop Buttons */
        .desktop-btns {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-login,
        .btn-try {
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-login {
            color: #333;
            border: 2px solid #DABB55;
            background: transparent;
        }

        .btn-login:hover {
            background: #DABB55;
            color: #fff;
        }

        .btn-try {
            background: #DABB55;
            color: #fff;
            border: 2px solid #DABB55;
        }

        .btn-try:hover {
            background: #c9a84a;
            border-color: #c9a84a;
            color: #fff;
        }

        /* Mobile Toggle */
        .mobile-nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-nav-toggle:hover {
            background: rgba(0,0,0,0.08);
            color: #DABB55;
        }

        .mobile-nav-toggle i {
            font-size: 24px;
            transition: all 0.3s ease;
        }

        /* Hide mobile-only buttons on desktop */
        .mobile-only-btns {
            display: none;
        }

        /* ===== MOBILE RESPONSIVE STYLES ===== */
        @media (max-width: 1199px) {
            .navmenu {
                position: fixed;
                top: 0;
                right: -320px;
                width: 280px;
                height: 100vh;
                background: #fff;
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                padding: 80px 25px 30px;
                box-shadow: -5px 0 25px rgba(0,0,0,0.15);
                transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 10000;
                overflow-y: auto;
            }

            .navmenu.active {
                right: 0;
            }

            .navmenu ul {
                flex-direction: column;
                width: 100%;
                gap: 5px;
            }

            .navmenu ul li {
                width: 100%;
            }

            .navmenu ul li a {
                padding: 14px 20px;
                font-size: 16px;
                border-radius: 8px;
                width: 100%;
            }

            .navmenu ul li a:hover,
            .navmenu ul li a.active {
                background: rgba(218, 181, 85, 0.15);
                padding-left: 25px;
            }

            /* Show mobile buttons inside drawer */
            .mobile-only-btns {
                display: flex;
                flex-direction: column;
                gap: 12px;
                margin-top: 25px;
                padding-top: 20px;
                border-top: 1px solid #eee;
                width: 100%;
            }

            .mobile-only-btns .btn-login,
            .mobile-only-btns .btn-try {
                width: 100%;
                text-align: center;
                padding: 14px;
                font-size: 16px;
            }

            /* Hide desktop buttons on mobile */
            .desktop-btns {
                display: none;
            }

            /* Show mobile toggle */
            .mobile-nav-toggle {
                display: flex;
                z-index: 10001;
            }
            
            .mobile-nav-toggle::before,
            .mobile-nav-toggle::after {
             display: none !important;
             content: none !important;
            }
            /* Overlay */
            .nav-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                z-index: 9998;
            }

            .nav-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            /* Prevent scroll when menu is open */
            body.menu-open {
                overflow: hidden;
            }
        }

        /* Extra small devices */
        @media (max-width: 575px) {
            #header .container-fluid {
                padding: 0 15px;
            }
            
            .navmenu {
                width: 100%;
                right: -100%;
            }
            
            .btn-login,
            .btn-try {
                padding: 9px 18px;
                font-size: 13px;
            }
        }

        /* ===== SCROLL TOP BUTTON ===== */
        #scroll-top {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 45px;
            height: 45px;
            background: #DABB55;
            color: #fff;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(218, 181, 85, 0.4);
            transition: all 0.3s ease;
            z-index: 9997;
        }

        #scroll-top:hover {
            background: #c9a84a;
            transform: translateY(-3px);
        }

        #scroll-top.active {
            display: flex;
        }

        /* ===== PRELOADER ===== */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #fff;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        #preloader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
    </style>
</head>

<body class="@yield('body_class', 'index-page')">

    <!-- ===== HEADER ===== -->
    <header id="header" class="header d-flex align-items-center">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/fleetshyp1.png') }}" alt="FleetShyp Logo" class="logo-img">
            </a>

            <!-- Desktop Navigation -->
            <nav id="navmenu" class="navmenu">
                <ul class="d-flex align-items-center">
                    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ url('/services') }}" class="{{ request()->is('services') ? 'active' : '' }}">Services</a></li>
                    <li><a href="{{ url('/pricing') }}" class="{{ request()->is('pricing') ? 'active' : '' }}">Pricing</a></li>
                    <li><a href="{{ url('/careers') }}" class="{{ request()->is('careers') ? 'active' : '' }}">Careers</a></li>
                    <li><a href="{{ url('/partner') }}" class="{{ request()->is('partner') ? 'active' : '' }}">Partners</a></li>
                    <li><a href="{{ url('/trackorder') }}" class="{{ request()->is('trackorder') ? 'active' : '' }}">Track Order</a></li>
                    <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
                </ul>
                
                <!-- Mobile Only Buttons (Inside Drawer) -->
                <div class="mobile-only-btns">
                    <a href="{{ route('seller.login') }}" class="btn-login">Login</a>
                    <a href="{{ route('seller.register') }}" class="btn-try">Try for Free</a>
                </div>
            </nav>

            <!-- Desktop Buttons -->
            <div class="desktop-btns d-none d-lg-flex align-items-center gap-2">
                <a href="{{ route('seller.login') }}" class="btn-login">Login</a>
                <a href="{{ route('seller.register') }}" class="btn-try">Try for Free</a>
            </div>

            <!-- Mobile Toggle Button -->
            <button class="mobile-nav-toggle d-lg-none" aria-label="Toggle navigation" aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>

        </div>
    </header>

    <!-- Overlay for Mobile Menu -->
    <div class="nav-overlay"></div>

    <!-- ===== MAIN CONTENT ===== -->
    <main id="main" style="margin-top: 80px;">
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
    <footer id="footer" class="footer dark-background">
        <div class="container footer-top">
            <div class="row gy-4">

                <!-- About -->
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
                        <img src="{{ asset('assets/img/fleetshyp1.png') }}" alt="FleetShyp Logo" style="height: 80px;">
                    </a>
                    <div class="footer-contact pt-3" style="margin-top: 0px;">
                        <p class="mt-3"><strong>Phone:</strong> +91 7482099650</p>
                        <p><strong>Email:</strong> support@fleetshyp.com </p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="https://x.com/FleetShyp" target="_blank" rel="noopener"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://www.facebook.com/people/Fleet-Shyp/61581278915677/" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/fleetshyp/" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                        <a href="https://youtube.com/@fleetshyp?si=t9nCkzFsE_Tyg16t" target="_blank" rel="noopener"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4 style="color:#000;">Useful Links</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/about') }}">About</a></li>
                        <li><a href="{{ url('/services') }}">Services</a></li>
                        <li><a href="{{ url('/pricing') }}">Pricing</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4 style="color:#000;">Our Services</h4>
                    <ul>
                        <!--<li><a href="#">Multi-Courier Integration</a></li>-->
                        <!--<li><a href="#">Order Management</a></li>-->
                        <!--<li><a href="#">Real-Time Tracking</a></li>-->
                        <!--<li><a href="#">RTO Reduction</a></li>-->
                        <!--<li><a href="#">Automated NDR</a></li>-->
                        <!--<li><a href="#">Analytics & Reports</a></li>-->
                        <li><a href="/termscondition">Terms & Conditions</a></li>
                        <li><a href="/refundcancellation">Return & Refund Policy</a></li>
                        <li><a href="/shippingpolicy">Shipping Policy</a></li>
                        <li><a href="/privacypolicy">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Locations -->
                <div class="col-lg-4 col-md-12 footer-map">
                    <h4 style="color:#000;">Our Locations</h4>
                    <div class="address-box mb-3 small">
                        <p class="mb-2">
                            <i class="bi bi-geo-alt-fill fs-5 me-2" style="color:#DABB55"></i> 
                            <strong class="fs-5">1-Branch:</strong><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;C-block Phase-2, Vikas Nagar, Uttam Nagar, New Delhi - 110059
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-geo-alt-fill fs-5 me-2" style="color:#DABB55"></i> 
                            <strong class="fs-5">2-Branch:</strong><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;Near Ford Hospital, NH-30, Khemnichak, New Jaganpura, Patna, Bihar - 800030
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-house fs-5 me-2" style="color:#DABB55"></i> 
                            <strong class="fs-5">Registered:</strong><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;Dagmara, Supaul, 847451
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="container text-center mt-4 pb-3">
            <p class="mb-0">© {{ date('Y') }} <strong>FleetShyp</strong> All Rights Reserved</p>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <!-- <div id="preloader">
        <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div> -->

    <!-- Vendor JS -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('header');
    const hero = document.getElementById('hero'); // Ensure your hero section has id="hero"

    if (!header || !hero) return;

    function updateHeader() {
        const heroRect = hero.getBoundingClientRect();
        // Agar hero ka bottom viewport ke top ke barabar ya upar chala jaye
        if (heroRect.bottom <= 0) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }

    // Scroll event (passive for better performance)
    window.addEventListener('scroll', updateHeader, { passive: true });
    
    // Page load par bhi check kare (agar user direct mid-page pe aa raha ho)
    updateHeader();
});
    </script>
    

    <!-- ✅ Optimized Header JS -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('header');
        const toggleBtn = document.querySelector('.mobile-nav-toggle');
        const navMenu = document.getElementById('navmenu');
        const overlay = document.querySelector('.nav-overlay');
        const scrollBtn = document.getElementById('scroll-top');
        const preloader = document.getElementById('preloader');
        const body = document.body;
        const navLinks = navMenu?.querySelectorAll('ul li a') || [];

        // Hide preloader after page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                preloader?.classList.add('hidden');
            }, 300);
        });

        // ===== Header Scroll Effect =====
        function handleHeaderScroll() {
            if (window.scrollY > 50) {
                header?.classList.add('scrolled');
            } else {
                header?.classList.remove('scrolled');
            }
            
            // Show/Hide scroll to top button
            if (scrollBtn) {
                if (window.scrollY > 300) {
                    scrollBtn.classList.add('active');
                 } else {
                    scrollBtn.classList.remove('active');
                }
            }
        }

        window.addEventListener('scroll', handleHeaderScroll, { passive: true });
        handleHeaderScroll(); // Initial check

        // ===== Mobile Menu Toggle =====
        function toggleMenu() {
            const isOpen = navMenu?.classList.contains('active');
            
            if (navMenu) navMenu.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active');
            
            if (toggleBtn) {
                toggleBtn.setAttribute('aria-expanded', !isOpen);
                
                // ✅ FIXED: Properly toggle between icons with else condition
const iconElement = toggleBtn.querySelector('i');

if (iconElement) {
    iconElement.classList.remove('bi-list', 'bi-x');

    if (isOpen) {
        iconElement.classList.add('bi-list'); // close → hamburger
    } else {
        iconElement.classList.add('bi-x'); // open → cross
    }
}
            }
            body.classList.toggle('menu-open');
        }

        // Toggle button click
        toggleBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMenu();
        });

        // Overlay click to close
        overlay?.addEventListener('click', toggleMenu);

        // Close menu when clicking a link
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (navMenu?.classList.contains('active')) {
                    toggleMenu();
                }
            });
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navMenu?.classList.contains('active')) {
                toggleMenu();
            }
        });

        // Prevent menu toggle from closing when clicking inside menu
        navMenu?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // ===== Smooth Scroll for Anchor Links =====
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const headerHeight = header?.offsetHeight || 80;
                        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // ===== Scroll to Top =====
        scrollBtn?.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ===== Initialize AOS (Animate On Scroll) =====
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100
            });
        }
    });
    </script>

    @stack('scripts')
</body>
</html>