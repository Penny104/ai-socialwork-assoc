<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '社團法人臺灣科技與社會工作協會')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+TC:wght@400;500;600;700;900&family=Noto+Sans+TC:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-bg:        #fdf9f4;
            --color-dark:      #1a1209;
            --color-teal:      #3b7a6b;
            --color-teal-light:#e6f4f0;
            --color-amber:     #e8a838;
            --color-rose:      #e07070;
            --color-lavender:  #9b8ec4;
            --color-border:    #e8e2d8;
            --color-text:      #2a2015;
            --color-muted:     #7a7060;
            --font-serif: 'Noto Serif TC', serif;
            --font-sans:  'Noto Sans TC', sans-serif;
        }
        html { scroll-behavior: auto; }
        html.lenis { height: auto; }
        .lenis.lenis-smooth { scroll-behavior: auto !important; }

        * { box-sizing: border-box; }
        body {
            background: var(--color-bg);
            color: var(--color-text);
            font-family: var(--font-sans);
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 3px; }
        ::-webkit-scrollbar-track { background: var(--color-bg); }
        ::-webkit-scrollbar-thumb { background: var(--color-amber); border-radius: 99px; }

        /* ── Navbar ── */
        .site-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 0 clamp(1.5rem, 5vw, 4rem);
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.4s ease, box-shadow 0.4s ease;
        }
        .site-nav.scrolled {
            background: rgba(253, 249, 244, 0.95);
            backdrop-filter: blur(12px);
            box-shadow: 0 1px 0 var(--color-border);
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            z-index: 101;
            position: relative;
        }
        .nav-logo-mark {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: var(--color-teal);
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-family: var(--font-serif);
            font-size: 11px;
            font-weight: 700;
            line-height: 1.2;
            text-align: center;
            flex-shrink: 0;
            box-shadow: 2px 3px 0 rgba(0,0,0,0.15);
            transition: transform 0.2s;
        }
        .nav-logo:hover .nav-logo-mark { transform: rotate(-3deg) scale(1.05); }
        .nav-logo-text { display: flex; flex-direction: column; }
        .nav-logo-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-dark);
            line-height: 1.3;
            letter-spacing: 0.02em;
        }
        .nav-logo-sub {
            font-size: 10px;
            color: var(--color-muted);
            letter-spacing: 0.04em;
        }

        /* ── MENU button ── */
        .menu-btn {
            position: relative;
            z-index: 101;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 1.1rem;
            border-radius: 9999px;
            border: 1.5px solid var(--color-border);
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(8px);
            cursor: pointer;
            font-family: var(--font-sans);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.12em;
            color: var(--color-dark);
            text-transform: uppercase;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
            box-shadow: 1px 2px 0 rgba(0,0,0,0.06);
        }
        .menu-btn:hover {
            border-color: var(--color-teal);
            background: rgba(255,255,255,0.95);
            box-shadow: 2px 3px 0 rgba(0,0,0,0.08);
        }
        .menu-btn-lines {
            display: flex;
            flex-direction: column;
            gap: 4px;
            width: 16px;
        }
        .menu-btn-lines span {
            display: block;
            height: 1.5px;
            background: var(--color-dark);
            border-radius: 2px;
            transition: all 0.3s ease;
            transform-origin: center;
        }
        .menu-btn.open .menu-btn-lines span:nth-child(1) { transform: rotate(45deg) translate(4px, 4px); }
        .menu-btn.open .menu-btn-lines span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .menu-btn.open .menu-btn-lines span:nth-child(3) { transform: rotate(-45deg) translate(4px, -4px); }

        /* ── Full-screen overlay menu ── */
        .nav-overlay {
            position: fixed;
            inset: 0;
            z-index: 99;
            background: var(--color-bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            clip-path: inset(0 0 100% 0);
            transition: clip-path 0.6s cubic-bezier(0.77, 0, 0.175, 1);
            pointer-events: none;
        }
        .nav-overlay.open {
            clip-path: inset(0 0 0% 0);
            pointer-events: all;
        }

        /* Decorative tape in overlay */
        .overlay-tape {
            position: absolute;
            width: 80px; height: 18px;
            border-radius: 2px;
            opacity: 0.55;
        }
        .overlay-tape-1 { top: 18%; left: 12%; background: var(--color-amber); transform: rotate(-8deg); }
        .overlay-tape-2 { bottom: 20%; right: 10%; background: var(--color-lavender); transform: rotate(5deg); }
        .overlay-tape-3 { top: 60%; left: 8%; width: 50px; background: var(--color-rose); opacity: 0.35; transform: rotate(-4deg); }

        .overlay-nav {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
            margin: 0; padding: 0;
        }
        .overlay-nav li { overflow: hidden; }
        .overlay-nav a {
            display: block;
            font-family: var(--font-serif);
            font-size: clamp(2rem, 5.5vw, 3.8rem);
            font-weight: 700;
            color: var(--color-dark);
            text-decoration: none;
            letter-spacing: 0.04em;
            line-height: 1.3;
            padding: 0.15em 0.5em;
            border-radius: 8px;
            transition: color 0.2s, background 0.2s;
            transform: translateY(100%);
            opacity: 0;
        }
        .overlay-nav a:hover {
            color: var(--color-teal);
            background: var(--color-teal-light);
        }
        .overlay-nav .nav-num {
            font-family: var(--font-sans);
            font-size: 0.35em;
            font-weight: 400;
            color: var(--color-muted);
            vertical-align: super;
            margin-right: 0.4em;
            letter-spacing: 0.1em;
        }

        .overlay-footer {
            position: absolute;
            bottom: 2.5rem;
            left: 50%;
            transform: translateX(-50%);
            font-size: 11px;
            color: var(--color-muted);
            letter-spacing: 0.1em;
            opacity: 0;
            white-space: nowrap;
        }

        /* ── Flash toast ── */
        .toast {
            position: fixed;
            top: 1.5rem; right: 1.5rem;
            z-index: 200;
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            animation: toastIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }
        .toast-success { background: var(--color-teal); color: white; }
        .toast-error   { background: #c0392b; color: white; }
        @keyframes toastIn {
            from { opacity: 0; transform: translateX(2rem); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ── GSAP animation targets ── */
        .reveal-line { overflow: hidden; display: block; }
        .reveal-line-inner { display: block; transform: translateY(100%); opacity: 0; }
        .fade-up { opacity: 0; transform: translateY(48px); }
        .fade-in { opacity: 0; }

        /* ── Footer ── */
        .site-footer {
            background: var(--color-dark);
            color: rgba(255,255,255,0.5);
            padding: 3rem clamp(1.5rem, 5vw, 4rem);
        }
        .footer-inner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }
        .footer-brand {
            font-family: var(--font-serif);
            font-size: 14px;
            font-weight: 700;
            color: rgba(255,255,255,0.85);
            margin-bottom: 0.35rem;
        }
        .footer-contact {
            font-size: 12px;
            line-height: 1.9;
            color: rgba(255,255,255,0.45);
        }
        .footer-contact a {
            color: rgba(255,255,255,0.45);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-contact a:hover { color: rgba(255,255,255,0.8); }
        .footer-social {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .footer-social a {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: border-color 0.2s, color 0.2s;
        }
        .footer-social a:hover {
            border-color: rgba(255,255,255,0.5);
            color: rgba(255,255,255,0.8);
        }
        .footer-copy {
            width: 100%;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 1.25rem;
            margin-top: 0.5rem;
            font-size: 11px;
            color: rgba(255,255,255,0.2);
            letter-spacing: 0.05em;
        }

        @media (max-width: 600px) {
            .nav-logo-sub { display: none; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

{{-- ── Navigation ── --}}
<header class="site-nav" id="site-nav">
    <a href="{{ route('home') }}" class="nav-logo">
        <div class="nav-logo-mark">科<br>社工</div>
        <div class="nav-logo-text">
            <span class="nav-logo-name">臺灣科技與社會工作協會</span>
            <span class="nav-logo-sub">Taiwan Technology & Social Work Association</span>
        </div>
    </a>

    <button class="menu-btn" id="menu-btn" aria-label="開啟選單" aria-expanded="false">
        <div class="menu-btn-lines">
            <span></span><span></span><span></span>
        </div>
        <span id="menu-label">MENU</span>
    </button>
</header>

{{-- ── Overlay Menu ── --}}
<div class="nav-overlay" id="nav-overlay" aria-hidden="true">
    {{-- Decorative washi tape --}}
    <div class="overlay-tape overlay-tape-1"></div>
    <div class="overlay-tape overlay-tape-2"></div>
    <div class="overlay-tape overlay-tape-3"></div>

    <ul class="overlay-nav" id="overlay-nav">
        <li><a href="{{ route('home') }}" class="overlay-link">
            <span class="nav-num">01</span>首頁
        </a></li>
        <li><a href="{{ route('home') }}#about" class="overlay-link">
            <span class="nav-num">02</span>協會簡介
        </a></li>
        <li><a href="{{ route('news.index') }}" class="overlay-link">
            <span class="nav-num">03</span>最新消息
        </a></li>
        <li><a href="{{ route('home') }}#members" class="overlay-link">
            <span class="nav-num">04</span>協會成員
        </a></li>
        <li><a href="{{ route('booking.index') }}" class="overlay-link">
            <span class="nav-num">05</span>課程預約
        </a></li>
        <li><a href="{{ route('home') }}#contact" class="overlay-link">
            <span class="nav-num">06</span>聯絡我們
        </a></li>
    </ul>

    <div class="overlay-footer" id="overlay-footer">
        © {{ date('Y') }} 社團法人臺灣科技與社會工作協會
    </div>
</div>

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div class="toast toast-success" id="toast">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="toast toast-error" id="toast">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        {{ session('error') }}
    </div>
@endif

{{-- ── Main Content ── --}}
<main>
    @yield('content')
</main>

{{-- ── Footer ── --}}
<footer class="site-footer" id="contact">
    <div class="footer-inner">
        <div>
            <div class="footer-brand">社團法人臺灣科技與社會工作協會</div>
            <div class="footer-contact">
                <div>📍 臺灣</div>
                <div>✉️ <a href="mailto:contact@tswa.org.tw">contact@tswa.org.tw</a></div>
                <div>📞 <a href="tel:+886-2-0000-0000">+886-2-0000-0000</a></div>
            </div>
        </div>
        <div class="footer-social">
            {{-- Facebook --}}
            <a href="#" aria-label="Facebook">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                </svg>
            </a>
            {{-- LINE --}}
            <a href="#" aria-label="LINE">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22 10.6c0-4.7-4.7-8.5-10.5-8.5S1 5.9 1 10.6c0 4.2 3.7 7.7 8.8 8.4.3.1.8.3.9.6.1.3.1.7 0 1l-.1.8c0 .3-.2 1.1 1 .6 1.1-.5 6.1-3.6 8.3-6.1 1.5-1.7 2.1-3.3 2.1-5.3z"/>
                </svg>
            </a>
            {{-- Instagram --}}
            <a href="#" aria-label="Instagram">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                    <circle cx="12" cy="12" r="4"/>
                    <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="footer-copy">© {{ date('Y') }} 社團法人臺灣科技與社會工作協會 · All Rights Reserved.</div>
</footer>

{{-- ── GSAP + ScrollTrigger + Lenis ── --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lenis@1.1.5/dist/lenis.min.js"></script>

<script>
// ── Lenis smooth scroll ──────────────────────────────────
const lenis = new Lenis({
    duration: 1.2,
    easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    smoothWheel: true,
});
lenis.on('scroll', ScrollTrigger.update);
gsap.ticker.add(time => lenis.raf(time * 1000));
gsap.ticker.lagSmoothing(0);

// ── Navbar scroll state ──────────────────────────────────
const nav = document.getElementById('site-nav');
ScrollTrigger.create({
    start: 'top -80',
    onUpdate: self => {
        nav.classList.toggle('scrolled', self.scroll() > 80);
    }
});

// ── Overlay Menu ─────────────────────────────────────────
const menuBtn    = document.getElementById('menu-btn');
const overlay    = document.getElementById('nav-overlay');
const menuLabel  = document.getElementById('menu-label');
const overlayLinks = document.querySelectorAll('.overlay-link');
const overlayFooter = document.getElementById('overlay-footer');
let menuOpen = false;

function openMenu() {
    menuOpen = true;
    menuBtn.classList.add('open');
    menuBtn.setAttribute('aria-expanded', 'true');
    overlay.classList.add('open');
    overlay.setAttribute('aria-hidden', 'false');
    menuLabel.textContent = 'CLOSE';
    lenis.stop();

    gsap.to(overlayLinks, {
        y: 0,
        opacity: 1,
        duration: 0.55,
        ease: 'power3.out',
        stagger: 0.07,
        delay: 0.25,
    });
    gsap.to(overlayFooter, { opacity: 1, duration: 0.6, delay: 0.7 });
}

function closeMenu() {
    menuOpen = false;
    menuBtn.classList.remove('open');
    menuBtn.setAttribute('aria-expanded', 'false');
    menuLabel.textContent = 'MENU';
    lenis.start();

    gsap.to(overlayLinks, { y: '100%', opacity: 0, duration: 0.35, ease: 'power2.in', stagger: 0.04 });
    gsap.to(overlayFooter, { opacity: 0, duration: 0.3 });

    setTimeout(() => {
        overlay.classList.remove('open');
        overlay.setAttribute('aria-hidden', 'true');
    }, 500);
}

menuBtn.addEventListener('click', () => menuOpen ? closeMenu() : openMenu());

overlayLinks.forEach(a => {
    a.addEventListener('click', () => closeMenu());
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && menuOpen) closeMenu();
});

// ── Universal fade-up on scroll ──────────────────────────
gsap.utils.toArray('.fade-up').forEach(el => {
    gsap.to(el, {
        opacity: 1,
        y: 0,
        duration: 0.9,
        ease: 'power3.out',
        scrollTrigger: {
            trigger: el,
            start: 'top 88%',
            toggleActions: 'play none none none',
        }
    });
});
gsap.utils.toArray('.fade-in').forEach(el => {
    gsap.to(el, {
        opacity: 1,
        duration: 1,
        ease: 'power2.out',
        scrollTrigger: {
            trigger: el,
            start: 'top 88%',
        }
    });
});

// ── Toast auto-dismiss ───────────────────────────────────
const toast = document.getElementById('toast');
if (toast) {
    setTimeout(() => {
        gsap.to(toast, { opacity: 0, x: 20, duration: 0.4, onComplete: () => toast.remove() });
    }, 4000);
}
</script>

@yield('scripts')
</body>
</html>
