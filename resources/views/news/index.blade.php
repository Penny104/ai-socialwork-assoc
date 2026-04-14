@extends('layouts.app')
@section('title', '最新消息 — 社團法人臺灣科技與社會工作協會')

@section('content')
<style>
.news-page-hero{padding:clamp(7rem,12vh,11rem) clamp(1.5rem,6vw,5rem) clamp(3rem,6vh,5rem);background:var(--color-dark);position:relative;overflow:hidden}
.news-page-hero-bg{position:absolute;inset:0;background:radial-gradient(ellipse 60% 80% at 20% 50%,rgba(45,107,94,.18),transparent 65%);pointer-events:none}
.news-page-hero-label{font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:rgba(255,255,255,.35);margin-bottom:1.25rem}
.news-page-hero-title{font-family:var(--font-serif);font-size:clamp(2.5rem,6vw,5.5rem);font-weight:900;color:#fff;line-height:1.1}

.news-body{padding:clamp(3rem,6vw,5rem) clamp(1.5rem,6vw,5rem);background:var(--color-bg);min-height:60vh}

/* filter bar */
.filter-bar{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:3rem}
.filter-btn{padding:.4rem 1.1rem;border-radius:9999px;font-size:12px;font-weight:500;letter-spacing:.04em;border:1px solid var(--color-border);background:#fff;color:var(--color-muted);text-decoration:none;transition:all .2s;cursor:pointer}
.filter-btn:hover,.filter-btn.active{background:var(--color-teal);color:#fff;border-color:var(--color-teal)}

/* news list */
.nl-border{border-top:1px solid var(--color-border)}
.nl-item{display:grid;grid-template-columns:6rem 1fr auto;align-items:center;gap:1.5rem;padding:1.5rem .5rem;border-bottom:1px solid var(--color-border);text-decoration:none;color:var(--color-text);border-radius:8px;transition:background .25s}
.nl-item:hover{background:white}
.nl-item:hover .nl-arrow{transform:translateX(5px);opacity:1}
.nl-item:hover .nl-title{color:var(--color-teal)}
.nl-badge{font-size:10px;letter-spacing:.06em;padding:.28rem .7rem;border-radius:4px;font-weight:600;white-space:nowrap;text-align:center}
.badge-ann{background:#dbeafe;color:#1d4ed8}
.badge-act{background:#dcfce7;color:#166534}
.badge-wel{background:#f3e8ff;color:#7e22ce}
.badge-oth{background:#f1f5f9;color:#475569}
.nl-meta{display:flex;flex-direction:column;gap:.25rem}
.nl-date{font-size:11px;color:var(--color-muted);letter-spacing:.05em}
.nl-title{font-size:15px;font-weight:500;color:var(--color-dark);line-height:1.5;transition:color .2s}
.nl-excerpt{font-size:13px;color:var(--color-muted);line-height:1.6;margin-top:.25rem}
.nl-arrow{color:var(--color-teal);opacity:.4;transition:transform .3s,opacity .3s;flex-shrink:0}
.nl-empty{padding:5rem 0;text-align:center;color:var(--color-muted);font-size:14px}

/* pagination override */
.pagination-wrap{margin-top:3rem;display:flex;justify-content:center}

@media(max-width:600px){
    .nl-item{grid-template-columns:1fr auto}
    .nl-badge{display:none}
}
</style>

{{-- Hero --}}
<section class="news-page-hero">
    <div class="news-page-hero-bg"></div>
    <p class="news-page-hero-label fade-in">News &amp; Announcements</p>
    <h1 class="news-page-hero-title fade-up">最新消息</h1>
</section>

{{-- Body --}}
<section class="news-body">

    {{-- Filter --}}
    @php
        $categories = ['' => '全部', 'announcement' => '公告', 'activity' => '活動', 'welfare' => '福利', 'other' => '其他'];
        $current = request('category', '');
        $badgeClass = ['announcement'=>'badge-ann','activity'=>'badge-act','welfare'=>'badge-wel','other'=>'badge-oth'];
        $badgeLabel = ['announcement'=>'公告','activity'=>'活動','welfare'=>'福利','other'=>'其他'];
    @endphp
    <div class="filter-bar fade-up">
        @foreach($categories as $val => $label)
            <a href="{{ route('news.index', $val ? ['category' => $val] : []) }}"
               class="filter-btn {{ $current === $val ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    {{-- List --}}
    @if($news->isEmpty())
        <div class="nl-empty">目前尚無消息公告。</div>
    @else
        <div class="nl-border">
            @foreach($news as $item)
                <a href="{{ route('news.show', $item) }}" class="nl-item fade-up">
                    <span class="nl-badge {{ $badgeClass[$item->category] ?? 'badge-oth' }}">
                        {{ $badgeLabel[$item->category] ?? '其他' }}
                    </span>
                    <div class="nl-meta">
                        <div class="nl-date">{{ $item->published_at?->format('Y . m . d') }}</div>
                        <div class="nl-title">{{ $item->title }}</div>
                        @if($item->excerpt)
                            <div class="nl-excerpt">{{ Str::limit($item->excerpt, 60) }}</div>
                        @endif
                    </div>
                    <svg class="nl-arrow" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            @endforeach
        </div>
        @if($news->hasPages())
            <div class="pagination-wrap">
                {{ $news->appends(request()->query())->links() }}
            </div>
        @endif
    @endif
</section>

@endsection

@section('scripts')
<script>
gsap.timeline({ delay: 0.15 })
    .to('.news-page-hero .fade-in', { opacity: 1, duration: 0.6 })
    .to('.news-page-hero .fade-up', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' }, '-=0.3');
</script>
@endsection
