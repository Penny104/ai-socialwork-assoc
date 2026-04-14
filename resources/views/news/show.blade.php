@extends('layouts.app')

@section('title', $news->title . ' — ' . config('app.name'))

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- Main Article --}}
        <article class="lg:col-span-2">
            {{-- Breadcrumb --}}
            <nav class="text-xs text-slate-400 mb-5 flex items-center gap-1.5">
                <a href="{{ route('home') }}" class="hover:text-teal-600">首頁</a>
                <span>/</span>
                <a href="{{ route('news.index') }}" class="hover:text-teal-600">最新消息</a>
                <span>/</span>
                <span class="text-slate-600 line-clamp-1">{{ $news->title }}</span>
            </nav>

            {{-- Category & Meta --}}
            @php
                $catColors = [
                    'announcement' => 'bg-blue-100 text-blue-700',
                    'activity'     => 'bg-green-100 text-green-700',
                    'welfare'      => 'bg-purple-100 text-purple-700',
                    'other'        => 'bg-slate-100 text-slate-600',
                ];
                $color = $catColors[$news->category] ?? 'bg-slate-100 text-slate-600';
            @endphp
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $color }}">
                    {{ \App\Models\News::categoryLabel($news->category) }}
                </span>
                <span class="text-xs text-slate-400">
                    {{ $news->published_at?->format('Y 年 m 月 d 日') }}
                </span>
                <span class="text-xs text-slate-400 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ number_format($news->view_count) }} 次瀏覽
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 leading-snug mb-8">
                {{ $news->title }}
            </h1>

            {{-- Content --}}
            <div class="prose prose-slate max-w-none
                        prose-headings:font-bold prose-headings:text-slate-800
                        prose-p:text-slate-700 prose-p:leading-relaxed
                        prose-a:text-teal-600 prose-a:no-underline hover:prose-a:underline
                        prose-li:text-slate-700">
                {!! $news->content !!}
            </div>

            {{-- Back button --}}
            <div class="mt-10 pt-6 border-t border-slate-200">
                <a href="{{ route('news.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-teal-600 transition-colors font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    返回消息列表
                </a>
            </div>
        </article>

        {{-- Sidebar --}}
        <aside class="space-y-6">

            {{-- Author Info --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <h3 class="text-sm font-semibold text-slate-700 mb-3">發布者</h3>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-sm">
                        {{ mb_substr($news->author->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-800">{{ $news->author->name }}</div>
                        <div class="text-xs text-slate-400">{{ $news->published_at?->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            {{-- Related News --}}
            @if($related->isNotEmpty())
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <h3 class="text-sm font-semibold text-slate-700 mb-4">相關消息</h3>
                    <ul class="space-y-3">
                        @foreach($related as $item)
                            <li>
                                <a href="{{ route('news.show', $item) }}"
                                   class="block group">
                                    <p class="text-sm text-slate-700 leading-snug group-hover:text-teal-600 transition-colors line-clamp-2">
                                        {{ $item->title }}
                                    </p>
                                    <span class="text-xs text-slate-400 mt-1 block">
                                        {{ $item->published_at?->format('Y/m/d') }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Course CTA --}}
            <div class="bg-teal-50 rounded-2xl border border-teal-100 p-5">
                <h3 class="text-sm font-semibold text-teal-800 mb-2">繼續教育課程</h3>
                <p class="text-xs text-teal-700 leading-relaxed mb-4">
                    查看最新開放報名的社工師繼續教育課程，累積換照積分。
                </p>
                <a href="{{ route('courses.index') }}"
                   class="inline-block w-full text-center bg-teal-600 text-white text-sm font-medium py-2 rounded-lg hover:bg-teal-700 transition-colors">
                    瀏覽課程
                </a>
            </div>
        </aside>
    </div>
</div>

@endsection
