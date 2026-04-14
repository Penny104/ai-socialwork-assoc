@extends('layouts.app')
@section('title', '社團法人臺灣科技與社會工作協會')

@section('content')
<style>
/* ═══════════════════════════════════════════
   HERO
═══════════════════════════════════════════ */
.hero {
    min-height: 100svh;
    padding: 0 clamp(1.5rem, 6vw, 5rem);
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    gap: 3rem;
    position: relative;
    overflow: hidden;
    background: var(--color-bg);
}
.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 45% 60% at 80% 30%, rgba(232,168,56,0.10), transparent 70%),
        radial-gradient(ellipse 40% 50% at 20% 75%, rgba(59,122,107,0.09), transparent 60%);
    pointer-events: none;
}

/* Ruled lines background (notebook feel) */
.hero-ruled {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}
.hero-ruled::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(
        transparent,
        transparent 39px,
        rgba(59,122,107,0.055) 40px
    );
}

/* Left column */
.hero-left { position: relative; z-index: 1; }
.hero-sticker-wrap {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1.75rem;
}
.hero-sticker {
    display: inline-block;
    padding: 0.28rem 0.85rem;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    position: relative;
}
.sticker-amber {
    background: var(--color-amber);
    color: white;
    transform: rotate(-2.5deg);
    box-shadow: 2px 2px 0 rgba(0,0,0,0.12);
}
.sticker-tape {
    width: 40px; height: 14px;
    background: rgba(155,142,196,0.55);
    border-radius: 2px;
    transform: rotate(6deg);
}
.hero-title {
    font-family: var(--font-serif);
    font-size: clamp(2.4rem, 5.5vw, 4.5rem);
    font-weight: 900;
    line-height: 1.15;
    color: var(--color-dark);
    margin-bottom: 1.25rem;
    letter-spacing: 0.01em;
}
.hero-title em {
    font-style: normal;
    color: var(--color-teal);
    position: relative;
    display: inline-block;
}
.hero-title em::after {
    content: '';
    position: absolute;
    bottom: 2px; left: 0; right: 0;
    height: 6px;
    background: rgba(232,168,56,0.4);
    z-index: -1;
    border-radius: 2px;
}
.hero-subtitle {
    font-size: clamp(13px, 1.4vw, 15px);
    color: var(--color-muted);
    line-height: 1.85;
    max-width: 42ch;
    margin-bottom: 2.25rem;
}
.hero-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1.75rem;
    border-radius: 9999px;
    background: var(--color-teal);
    color: white;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    letter-spacing: 0.06em;
    box-shadow: 3px 4px 0 rgba(59,122,107,0.35);
    transition: transform 0.2s, box-shadow 0.2s;
}
.hero-cta:hover {
    transform: translate(-1px,-2px);
    box-shadow: 4px 6px 0 rgba(59,122,107,0.35);
}
.hero-cta svg { flex-shrink: 0; }

.hero-doodle-1 {
    position: absolute;
    top: 12%; right: 48%;
    font-size: 1.8rem;
    opacity: 0.25;
    transform: rotate(-12deg);
    pointer-events: none;
}
.hero-doodle-2 {
    position: absolute;
    bottom: 15%; left: 3%;
    font-size: 1.5rem;
    opacity: 0.2;
    transform: rotate(8deg);
    pointer-events: none;
}

/* Right column — illustration */
.hero-right {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hero-illustration {
    width: 100%;
    max-width: 440px;
    filter: drop-shadow(4px 8px 24px rgba(0,0,0,0.08));
}
.hero-img-tape {
    position: absolute;
    top: -10px; left: 50%;
    transform: translateX(-50%) rotate(-2deg);
    width: 80px; height: 20px;
    background: rgba(155,142,196,0.6);
    border-radius: 3px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.hero-img-shadow {
    position: relative;
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 4px 8px 0 rgba(0,0,0,0.08), 0 2px 16px rgba(0,0,0,0.06);
    transform: rotate(1.5deg);
}

@media (max-width: 768px) {
    .hero { grid-template-columns: 1fr; padding-top: 6rem; }
    .hero-right { display: none; }
}

/* ═══════════════════════════════════════════
   ABOUT — Book-flip
═══════════════════════════════════════════ */
.about-wrap {
    padding: clamp(5rem,10vh,8rem) clamp(1.5rem,6vw,5rem);
}
.about-label {
    font-size: 11px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--color-muted);
    margin-bottom: 1rem;
}
.about-title {
    font-family: var(--font-serif);
    font-size: clamp(1.8rem, 4vw, 3rem);
    font-weight: 900;
    color: var(--color-dark);
    margin-bottom: 3rem;
}
.book-container {
    perspective: 1400px;
    width: 100%;
    max-width: 860px;
    margin: 0 auto;
}
.book-spread {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.12), 4px 4px 0 rgba(0,0,0,0.04);
    position: relative;
    background: white;
}
.book-spread::after {
    content: '';
    position: absolute;
    left: 50%; top: 0; bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, rgba(0,0,0,0.12), rgba(0,0,0,0.05), rgba(0,0,0,0.12));
    transform: translateX(-50%);
    pointer-events: none;
}
.book-page {
    padding: 3rem 2.5rem;
    background: white;
    background-image: repeating-linear-gradient(
        transparent,
        transparent 27px,
        rgba(59,122,107,0.06) 28px
    );
    background-position: 0 60px;
    min-height: 360px;
    display: flex;
    flex-direction: column;
    position: relative;
}
.page-left { border-right: 1px solid rgba(0,0,0,0.06); }
.book-page-num {
    font-size: 10px;
    color: var(--color-muted);
    letter-spacing: 0.1em;
    margin-bottom: 0.75rem;
    opacity: 0.5;
}
.book-page-tag {
    display: inline-block;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.08em;
    padding: 0.2rem 0.65rem;
    border-radius: 3px;
    background: var(--color-teal-light);
    color: var(--color-teal);
    margin-bottom: 1rem;
}
.book-page-title {
    font-family: var(--font-serif);
    font-size: clamp(1.2rem, 2.5vw, 1.75rem);
    font-weight: 700;
    color: var(--color-dark);
    line-height: 1.3;
    margin-bottom: 1rem;
}
.book-page-body {
    font-size: 14px;
    line-height: 2;
    color: var(--color-muted);
    flex: 1;
}
.book-page-icon {
    font-size: 2.5rem;
    margin-bottom: 0.75rem;
    line-height: 1;
}
.sticky-note {
    position: absolute;
    bottom: 1.5rem; right: 1.5rem;
    width: 80px; height: 80px;
    background: rgba(232,168,56,0.18);
    border-radius: 2px;
    transform: rotate(3deg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    box-shadow: 1px 2px 4px rgba(0,0,0,0.07);
}

.book-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.5rem;
    max-width: 860px;
    margin-left: auto;
    margin-right: auto;
    padding: 0 0.25rem;
}
.book-nav-dots { display: flex; gap: 0.5rem; }
.book-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    border: 1.5px solid var(--color-teal);
    background: transparent;
    cursor: pointer;
    transition: background 0.2s;
    padding: 0;
}
.book-dot.active { background: var(--color-teal); }
.book-arrow {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1.25rem;
    border-radius: 9999px;
    border: 1.5px solid var(--color-border);
    background: white;
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    color: var(--color-dark);
    letter-spacing: 0.06em;
    transition: border-color 0.2s, color 0.2s, transform 0.2s, box-shadow 0.2s;
    box-shadow: 1px 2px 0 rgba(0,0,0,0.05);
}
.book-arrow:hover {
    border-color: var(--color-teal);
    color: var(--color-teal);
    transform: translate(-1px,-1px);
    box-shadow: 2px 3px 0 rgba(59,122,107,0.2);
}
.book-prev { display: none; }
.book-prev.visible { display: flex; }

.book-spread.flip-out {
    animation: bookFlipOut 0.32s cubic-bezier(0.55,0,1,0.45) both;
    transform-origin: left center;
}
.book-spread.flip-in {
    animation: bookFlipIn 0.4s cubic-bezier(0,0.55,0.45,1) both;
    transform-origin: left center;
}
@keyframes bookFlipOut {
    from { transform: perspective(900px) rotateY(0deg); opacity: 1; }
    to   { transform: perspective(900px) rotateY(-35deg); opacity: 0; }
}
@keyframes bookFlipIn {
    from { transform: perspective(900px) rotateY(35deg); opacity: 0; }
    to   { transform: perspective(900px) rotateY(0deg); opacity: 1; }
}

@media (max-width: 600px) {
    .book-spread { grid-template-columns: 1fr; }
    .book-spread::after { display: none; }
    .page-left { border-right: none; border-bottom: 1px solid rgba(0,0,0,0.06); }
}

/* ═══════════════════════════════════════════
   NEWS
═══════════════════════════════════════════ */
.news-section {
    padding: clamp(5rem,10vh,8rem) clamp(1.5rem,6vw,5rem);
    background: #f3ede4;
    position: relative;
    overflow: hidden;
}
.news-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(59,122,107,0.04) 1px, transparent 1px);
    background-size: 24px 24px;
    pointer-events: none;
}
.section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 2.5rem;
    gap: 1rem;
}
.section-label {
    font-size: 11px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--color-muted);
    margin-bottom: 0.5rem;
}
.section-title {
    font-family: var(--font-serif);
    font-size: clamp(1.8rem, 4vw, 2.75rem);
    font-weight: 900;
    color: var(--color-dark);
    line-height: 1.2;
}
.section-more {
    font-size: 12px;
    font-weight: 600;
    color: var(--color-teal);
    text-decoration: none;
    letter-spacing: 0.08em;
    border-bottom: 1.5px solid var(--color-teal);
    padding-bottom: 1px;
    white-space: nowrap;
    transition: opacity 0.2s;
    flex-shrink: 0;
    margin-bottom: 0.35rem;
}
.section-more:hover { opacity: 0.7; }

.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px,1fr));
    gap: 1.5rem;
}
.news-card {
    background: white;
    border-radius: 14px;
    overflow: visible;
    box-shadow: 2px 4px 0 rgba(0,0,0,0.05), 0 2px 12px rgba(0,0,0,0.04);
    cursor: pointer;
    transition: transform 0.25s, box-shadow 0.25s;
    position: relative;
    margin-top: 8px;
}
.news-card:hover {
    transform: translate(-2px,-4px);
    box-shadow: 4px 8px 0 rgba(0,0,0,0.08), 0 4px 20px rgba(0,0,0,0.07);
}
.news-card::before {
    content: '';
    position: absolute;
    top: -7px; left: 50%;
    transform: translateX(-50%) rotate(-1deg);
    width: 50px; height: 14px;
    border-radius: 2px;
    z-index: 1;
}
.news-card:nth-child(odd)::before  { background: rgba(232,168,56,0.55); }
.news-card:nth-child(even)::before { background: rgba(155,142,196,0.5); }
.news-card:nth-child(3n)::before   { background: rgba(224,112,112,0.45); }

.news-card-img {
    width: 100%;
    height: 150px;
    background: linear-gradient(135deg, var(--color-teal-light), #e8e4f4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    flex-shrink: 0;
    border-radius: 14px 14px 0 0;
    overflow: hidden;
}
.news-card-body { padding: 1.25rem 1.25rem 1.5rem; }
.news-card-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.6rem;
}
.news-card-badge {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.08em;
    padding: 0.2rem 0.55rem;
    border-radius: 3px;
}
.badge-ann { background: #dbeafe; color: #1d4ed8; }
.badge-act { background: #dcfce7; color: #166534; }
.badge-wel { background: #f3e8ff; color: #7e22ce; }
.badge-oth { background: #f1f5f9; color: #475569; }
.news-card-date { font-size: 11px; color: var(--color-muted); letter-spacing: 0.04em; }
.news-card-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--color-dark);
    line-height: 1.5;
    margin-bottom: 0.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.news-card-excerpt {
    font-size: 13px;
    color: var(--color-muted);
    line-height: 1.65;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 1rem;
}
.news-card-expand {
    display: none;
    font-size: 13px;
    color: var(--color-muted);
    line-height: 1.7;
    margin-bottom: 1rem;
    border-top: 1px dashed var(--color-border);
    padding-top: 0.75rem;
    margin-top: 0.25rem;
}
.news-card.expanded .news-card-expand { display: block; }
.news-card.expanded .news-card-excerpt { display: none; }
.news-card-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 11px;
    font-weight: 600;
    color: var(--color-teal);
    letter-spacing: 0.06em;
    text-decoration: none;
    transition: gap 0.2s;
}
.news-card-btn:hover { gap: 0.6rem; }
.news-card-btn svg { transition: transform 0.2s; }
.news-card-btn:hover svg { transform: translateX(3px); }

/* ═══════════════════════════════════════════
   MEMBERS
═══════════════════════════════════════════ */
.members-wrap {
    padding: clamp(5rem,10vh,8rem) clamp(1.5rem,6vw,5rem);
    background: var(--color-bg);
}
.members-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px,1fr));
    gap: 2rem;
    margin-top: 2.5rem;
}
.member-blob {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 0.75rem;
    opacity: 0;
    transform: translateY(32px);
}
.blob-shape {
    width: 130px; height: 130px;
    background: var(--color-teal-light);
    border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: transform 0.4s ease;
    box-shadow: 3px 5px 0 rgba(0,0,0,0.06);
    cursor: default;
}
.blob-shape:hover { transform: scale(1.06) rotate(3deg); }
.blob-num {
    font-family: var(--font-serif);
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--color-teal);
    line-height: 1;
}
.blob-unit { font-size: 11px; color: var(--color-muted); letter-spacing: 0.08em; }
.member-label { font-size: 13px; font-weight: 500; color: var(--color-dark); }
.member-sub { font-size: 11px; color: var(--color-muted); letter-spacing: 0.04em; }
.blob-amber { background: rgba(232,168,56,0.15); }
.blob-amber .blob-num { color: var(--color-amber); }
.blob-rose { background: rgba(224,112,112,0.12); }
.blob-rose .blob-num { color: var(--color-rose); }
.blob-lav { background: rgba(155,142,196,0.15); }
.blob-lav .blob-num { color: var(--color-lavender); }
.blob-b { border-radius: 45% 55% 37% 63% / 48% 62% 38% 52%; }
.blob-c { border-radius: 52% 48% 61% 39% / 44% 55% 45% 56%; }
.blob-d { border-radius: 38% 62% 50% 50% / 58% 41% 59% 42%; }
.blob-e { border-radius: 60% 40% 44% 56% / 51% 63% 37% 49%; }
</style>

{{-- ═══════════════════════════════════════════
     HERO
════════════════════════════════════════════ --}}
<section class="hero" id="hero">
    <div class="hero-ruled"></div>
    <div class="hero-doodle-1">✏️</div>
    <div class="hero-doodle-2">💡</div>

    <div class="hero-left">
        <div class="hero-sticker-wrap">
            <span class="hero-sticker sticker-amber">科技 × 社工</span>
            <span class="sticker-tape"></span>
        </div>

        <h1 class="hero-title">
            用科技之力<br>
            <em>溫暖</em>社會工作
        </h1>

        <p class="hero-subtitle">
            社團法人臺灣科技與社會工作協會致力於推動 AI 與數位工具在社會工作領域的應用，提升社工師專業能力，促進社會福祉。
        </p>

        <a href="#about" class="hero-cta">
            認識我們
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

    {{-- SVG Illustration --}}
    <div class="hero-right">
        <div style="position:relative; display:inline-block;">
            <div class="hero-img-tape"></div>
            <div class="hero-img-shadow">
                <svg class="hero-illustration" viewBox="0 0 420 380" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Background -->
                    <rect x="10" y="10" width="400" height="360" rx="20" fill="#fafaf8" stroke="#e8e2d8" stroke-width="1.5"/>
                    <!-- Ruled lines -->
                    <line x1="30" y1="70" x2="390" y2="70" stroke="#e8e2d8" stroke-width="0.8"/>
                    <line x1="30" y1="98" x2="390" y2="98" stroke="#e8e2d8" stroke-width="0.8"/>
                    <line x1="30" y1="126" x2="390" y2="126" stroke="#e8e2d8" stroke-width="0.8"/>
                    <line x1="30" y1="154" x2="390" y2="154" stroke="#e8e2d8" stroke-width="0.8"/>
                    <!-- Title text -->
                    <text x="210" y="50" text-anchor="middle" font-family="serif" font-size="13" fill="#2a2015" font-weight="700" letter-spacing="2">科技 × 社會工作</text>
                    <!-- Social worker body -->
                    <ellipse cx="155" cy="230" rx="45" ry="55" fill="#3b7a6b" opacity="0.9"/>
                    <!-- Head -->
                    <circle cx="155" cy="160" r="36" fill="#f5d0a9"/>
                    <!-- Hair -->
                    <ellipse cx="155" cy="138" rx="38" ry="18" fill="#2a1a0a" opacity="0.85"/>
                    <!-- Eyes -->
                    <circle cx="143" cy="162" r="5" fill="#2a1a0a"/>
                    <circle cx="167" cy="162" r="5" fill="#2a1a0a"/>
                    <circle cx="145" cy="160" r="2" fill="white"/>
                    <circle cx="169" cy="160" r="2" fill="white"/>
                    <!-- Smile -->
                    <path d="M144 174 Q155 184 166 174" stroke="#2a1a0a" stroke-width="2" stroke-linecap="round" fill="none"/>
                    <!-- Cheeks -->
                    <circle cx="136" cy="172" r="8" fill="#f0a0a0" opacity="0.4"/>
                    <circle cx="174" cy="172" r="8" fill="#f0a0a0" opacity="0.4"/>
                    <!-- Arms -->
                    <path d="M113 225 Q90 240 95 265" stroke="#3b7a6b" stroke-width="18" stroke-linecap="round" fill="none"/>
                    <path d="M197 225 Q220 240 215 265" stroke="#3b7a6b" stroke-width="18" stroke-linecap="round" fill="none"/>
                    <!-- Hands -->
                    <circle cx="95" cy="270" r="12" fill="#f5d0a9"/>
                    <circle cx="215" cy="270" r="12" fill="#f5d0a9"/>
                    <!-- Legs -->
                    <rect x="133" y="282" width="18" height="55" rx="9" fill="#5a4a3a"/>
                    <rect x="159" y="282" width="18" height="55" rx="9" fill="#5a4a3a"/>
                    <!-- Shoes -->
                    <ellipse cx="142" cy="337" rx="14" ry="8" fill="#2a1a0a"/>
                    <ellipse cx="168" cy="337" rx="14" ry="8" fill="#2a1a0a"/>
                    <!-- Badge -->
                    <rect x="138" y="195" width="34" height="20" rx="4" fill="white" opacity="0.9"/>
                    <text x="155" y="209" text-anchor="middle" font-family="sans-serif" font-size="8" fill="#3b7a6b" font-weight="700">社工師</text>
                    <!-- Laptop body -->
                    <rect x="248" y="200" width="130" height="85" rx="8" fill="#2a2a2a"/>
                    <rect x="254" y="206" width="118" height="68" rx="4" fill="#1a1a1a"/>
                    <!-- Screen lines -->
                    <rect x="260" y="212" width="60" height="5" rx="2" fill="#3b7a6b" opacity="0.8"/>
                    <rect x="260" y="222" width="80" height="4" rx="2" fill="#e8a838" opacity="0.7"/>
                    <rect x="260" y="231" width="50" height="4" rx="2" fill="#9b8ec4" opacity="0.7"/>
                    <rect x="260" y="240" width="70" height="4" rx="2" fill="#3b7a6b" opacity="0.5"/>
                    <rect x="260" y="249" width="40" height="4" rx="2" fill="#e07070" opacity="0.6"/>
                    <rect x="260" y="258" width="65" height="4" rx="2" fill="#e8a838" opacity="0.5"/>
                    <!-- Cursor -->
                    <rect x="330" y="258" width="8" height="4" rx="1" fill="white" opacity="0.7"/>
                    <!-- AI badge on screen -->
                    <circle cx="348" cy="228" r="18" fill="#3b7a6b" opacity="0.3"/>
                    <text x="348" y="233" text-anchor="middle" font-family="sans-serif" font-size="14" fill="#3b7a6b" font-weight="700">AI</text>
                    <!-- Laptop base -->
                    <rect x="238" y="285" width="150" height="10" rx="4" fill="#3a3a3a"/>
                    <rect x="295" y="282" width="36" height="5" rx="2" fill="#2a2a2a"/>
                    <!-- Connection line -->
                    <path d="M215 270 Q232 255 248 250" stroke="#e8a838" stroke-width="2" stroke-dasharray="5,4" opacity="0.7" stroke-linecap="round" fill="none"/>
                    <!-- Sticker elements -->
                    <rect x="55" y="300" width="50" height="50" rx="8" fill="#fef9ee" stroke="#e8e2d8" stroke-width="1"/>
                    <text x="80" y="332" text-anchor="middle" font-size="24">💡</text>
                    <rect x="340" y="310" width="45" height="45" rx="8" fill="#fef0f0" stroke="#e8e2d8" stroke-width="1" transform="rotate(-5 362 332)"/>
                    <text x="362" y="340" text-anchor="middle" font-size="20">❤️</text>
                    <rect x="55" y="60" width="40" height="40" rx="8" fill="#f0f7f5" stroke="#e8e2d8" stroke-width="1" transform="rotate(8 75 80)"/>
                    <text x="75" y="85" text-anchor="middle" font-size="18">⭐</text>
                    <!-- Washi tape -->
                    <rect x="0" y="0" width="80" height="18" rx="2" fill="rgba(155,142,196,0.4)" transform="rotate(-3) translate(20,8)"/>
                </svg>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     ABOUT
════════════════════════════════════════════ --}}
<section id="about" style="scroll-margin-top: 72px; background: var(--color-bg);">
    <div class="about-wrap">
        <p class="about-label fade-in">About Us</p>
        <h2 class="about-title fade-up">認識我們</h2>

        <div class="book-container fade-up">
            <div class="book-spread" id="book-spread"></div>
        </div>

        <div class="book-nav">
            <button class="book-arrow book-prev" id="book-prev">← 上一頁</button>
            <div class="book-nav-dots" id="book-dots"></div>
            <button class="book-arrow book-next" id="book-next">下一頁 →</button>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     NEWS
════════════════════════════════════════════ --}}
<section class="news-section" id="news-section">
    <div class="section-header fade-up">
        <div>
            <p class="section-label">News</p>
            <h2 class="section-title">最新消息</h2>
        </div>
        <a href="{{ route('news.index') }}" class="section-more">查看全部 →</a>
    </div>

    @php
        $badgeClass = ['announcement'=>'badge-ann','activity'=>'badge-act','welfare'=>'badge-wel','other'=>'badge-oth'];
        $badgeLabel = ['announcement'=>'公告','activity'=>'活動','welfare'=>'福利','other'=>'其他'];
        $cardIcon   = ['announcement'=>'📢','activity'=>'🎉','welfare'=>'💚','other'=>'📌'];
    @endphp

    <div class="news-grid">
        @forelse($latestNews as $item)
            <article class="news-card fade-up" onclick="toggleNewsCard(this)">
                <div class="news-card-img">{{ $cardIcon[$item->category] ?? '📌' }}</div>
                <div class="news-card-body">
                    <div class="news-card-meta">
                        <span class="news-card-badge {{ $badgeClass[$item->category] ?? 'badge-oth' }}">
                            {{ $badgeLabel[$item->category] ?? '其他' }}
                        </span>
                        <span class="news-card-date">{{ $item->published_at?->format('Y.m.d') }}</span>
                    </div>
                    <div class="news-card-title">{{ $item->title }}</div>
                    <div class="news-card-excerpt">{{ $item->excerpt ?: Str::limit(strip_tags($item->content ?? ''), 60) }}</div>
                    <div class="news-card-expand">{{ $item->content ? Str::limit(strip_tags($item->content), 200) : $item->excerpt }}</div>
                    <a href="{{ route('news.show', $item) }}" class="news-card-btn" onclick="event.stopPropagation()">
                        閱讀更多
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </article>
        @empty
            <div style="grid-column:1/-1; text-align:center; color:var(--color-muted); padding:3rem 0; font-size:14px;">
                目前尚無消息公告。
            </div>
        @endforelse
    </div>
</section>

{{-- ═══════════════════════════════════════════
     MEMBERS
════════════════════════════════════════════ --}}
<section id="members" style="scroll-margin-top: 72px;">
    <div class="members-wrap">
        <p class="section-label fade-in">Our Members</p>
        <h2 class="section-title fade-up">協會成員</h2>
        <p class="fade-up" style="font-size:14px; color:var(--color-muted); margin-top:0.5rem; max-width:50ch; line-height:1.8;">
            由社工師、研究人員與科技專業人士共同組成，致力推動跨領域合作。
        </p>

        <div class="members-grid">
            <div class="member-blob">
                <div class="blob-shape blob-amber">
                    <span class="blob-num">120</span>
                    <span class="blob-unit">位</span>
                </div>
                <div class="member-label">正式會員</div>
                <div class="member-sub">Formal Members</div>
            </div>
            <div class="member-blob">
                <div class="blob-shape blob-b">
                    <span class="blob-num">45</span>
                    <span class="blob-unit">位</span>
                </div>
                <div class="member-label">理監事</div>
                <div class="member-sub">Board Members</div>
            </div>
            <div class="member-blob">
                <div class="blob-shape blob-rose blob-c">
                    <span class="blob-num">30</span>
                    <span class="blob-unit">所</span>
                </div>
                <div class="member-label">合作機構</div>
                <div class="member-sub">Partner Organizations</div>
            </div>
            <div class="member-blob">
                <div class="blob-shape blob-lav blob-d">
                    <span class="blob-num">8</span>
                    <span class="blob-unit">年</span>
                </div>
                <div class="member-label">成立年份</div>
                <div class="member-sub">Years of Service</div>
            </div>
            <div class="member-blob">
                <div class="blob-shape blob-e" style="background:rgba(232,168,56,0.12);">
                    <span class="blob-num" style="color:var(--color-amber);">200+</span>
                    <span class="blob-unit">場</span>
                </div>
                <div class="member-label">培訓課程</div>
                <div class="member-sub">Training Sessions</div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
// ── Book pages data ───────────────────────────────────
const bookPages = [
    {
        left:  { tag:'協會理念', icon:'🌱', num:'P.01', title:'以人為本，科技為翼',
                 body:'我們相信科技是社會工作的翅膀，而非替代品。透過 AI 工具與數位資源，讓社工師能夠更有效地服務弱勢族群，創造更美好的社會。' },
        right: { tag:'核心價值', icon:'✨', num:'P.02', title:'專業・創新・關懷',
                 body:'專業是我們的基石，創新是我們的動力，關懷是我們的初心。三者相互交織，構成協會的核心精神。', sticky:'💪' }
    },
    {
        left:  { tag:'協會目標', icon:'🎯', num:'P.03', title:'推動科技與社工整合',
                 body:'• 建立科技社工知識庫\n• 辦理繼續教育培訓課程\n• 推動政策倡議與研究\n• 促進國際交流合作\n• 支持社工數位轉型' },
        right: { tag:'近期成果', icon:'📊', num:'P.04', title:'2024年度成果',
                 body:'培訓社工師 500+ 位、舉辦工作坊 20 場、出版 AI 社工應用指引手冊、與 15 所大學建立合作關係。', sticky:'🏆' }
    },
    {
        left:  { tag:'科技社工介紹', icon:'💻', num:'P.05', title:'什麼是科技社工？',
                 body:'科技社工結合傳統社會工作與數位科技能力，運用資料分析、App 開發、AI 工具等方法，提升服務效能與觸及範圍。' },
        right: { tag:'應用領域', icon:'🔬', num:'P.06', title:'科技社工的多元應用',
                 body:'案例管理數位化、AI 風險評估、遠距服務、數據驅動政策、智慧福利系統……科技正在重新定義社會工作的邊界。', sticky:'🚀' }
    },
    {
        left:  { tag:'AI 社會工作', icon:'🤖', num:'P.07', title:'AI 如何改變社會工作',
                 body:'人工智慧協助社工師快速整合資訊、預測服務需求、自動化行政作業，讓社工師有更多時間投入直接服務與關係建立。' },
        right: { tag:'倫理框架', icon:'⚖️', num:'P.08', title:'AI 社工倫理指引',
                 body:'在擁抱科技的同時，我們堅守：透明性、公平性、隱私保護、人性關懷。科技服務於人，而不凌駕於人。', sticky:'💡' }
    }
];

let currentPage = 0;
const spread   = document.getElementById('book-spread');
const dotsWrap = document.getElementById('book-dots');
const btnNext  = document.getElementById('book-next');
const btnPrev  = document.getElementById('book-prev');

function buildPageHTML(page) {
    const stickyHTML = page.right.sticky
        ? `<div class="sticky-note">${page.right.sticky}</div>` : '';
    return `
        <div class="book-page page-left">
            <div class="book-page-num">${page.left.num}</div>
            <div class="book-page-icon">${page.left.icon}</div>
            <span class="book-page-tag">${page.left.tag}</span>
            <div class="book-page-title">${page.left.title}</div>
            <div class="book-page-body" style="white-space:pre-line">${page.left.body}</div>
        </div>
        <div class="book-page">
            <div class="book-page-num">${page.right.num}</div>
            <div class="book-page-icon">${page.right.icon}</div>
            <span class="book-page-tag">${page.right.tag}</span>
            <div class="book-page-title">${page.right.title}</div>
            <div class="book-page-body">${page.right.body}</div>
            ${stickyHTML}
        </div>`;
}

function renderPage(idx) {
    spread.classList.add('flip-out');
    setTimeout(() => {
        spread.innerHTML = buildPageHTML(bookPages[idx]);
        spread.classList.remove('flip-out');
        spread.classList.add('flip-in');
        setTimeout(() => spread.classList.remove('flip-in'), 500);
        updateControls();
    }, 280);
}

function updateControls() {
    dotsWrap.querySelectorAll('.book-dot').forEach((d, i) => d.classList.toggle('active', i === currentPage));
    btnPrev.classList.toggle('visible', currentPage > 0);
    btnNext.textContent = currentPage === bookPages.length - 1 ? '回到第一頁 ↩' : '下一頁 →';
}

// Init dots
bookPages.forEach((_, i) => {
    const dot = document.createElement('button');
    dot.className = 'book-dot' + (i === 0 ? ' active' : '');
    dot.setAttribute('aria-label', `第 ${i+1} 章`);
    dot.addEventListener('click', () => { if (i !== currentPage) { currentPage = i; renderPage(currentPage); } });
    dotsWrap.appendChild(dot);
});

// Initial render (no animation)
spread.innerHTML = buildPageHTML(bookPages[0]);
updateControls();

btnNext.addEventListener('click', () => {
    currentPage = currentPage < bookPages.length - 1 ? currentPage + 1 : 0;
    renderPage(currentPage);
});
btnPrev.addEventListener('click', () => {
    if (currentPage > 0) { currentPage--; renderPage(currentPage); }
});

// ── News card expand/collapse ─────────────────────────
function toggleNewsCard(card) {
    const wasExpanded = card.classList.contains('expanded');
    document.querySelectorAll('.news-card.expanded').forEach(c => c.classList.remove('expanded'));
    if (!wasExpanded) card.classList.add('expanded');
}

// ── Members blob entrance ─────────────────────────────
gsap.utils.toArray('.member-blob').forEach((el, i) => {
    gsap.to(el, {
        opacity: 1, y: 0, duration: 0.7, ease: 'power3.out',
        delay: i * 0.1,
        scrollTrigger: { trigger: el, start: 'top 88%' },
    });
});

// ── Hero entrance ─────────────────────────────────────
gsap.timeline({ delay: 0.2 })
    .from('.hero-sticker-wrap', { opacity:0, y:20, duration:0.6 })
    .from('.hero-title',        { opacity:0, y:30, duration:0.7, ease:'power3.out' }, '-=0.3')
    .from('.hero-subtitle',     { opacity:0, y:20, duration:0.6 }, '-=0.4')
    .from('.hero-cta',          { opacity:0, y:16, duration:0.5 }, '-=0.3')
    .from('.hero-right',        { opacity:0, x:30, duration:0.8, ease:'power3.out' }, '-=0.7');
</script>
@endsection
