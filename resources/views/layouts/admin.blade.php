<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '管理後台') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased">

<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-56 bg-slate-800 text-slate-200 flex flex-col shrink-0">
        <div class="px-5 py-5 border-b border-slate-700">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-teal-500 flex items-center justify-center text-white font-bold text-xs">社工</div>
                <div>
                    <div class="text-xs font-semibold text-white leading-tight">台灣社工師公會</div>
                    <div class="text-xs text-slate-400">管理後台</div>
                </div>
            </a>
        </div>
        <nav class="flex-1 px-3 py-4 space-y-0.5">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 text-white' : 'hover:bg-slate-700 text-slate-300' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                控制台
            </a>
            <a href="{{ route('admin.news.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.news.*') ? 'bg-teal-600 text-white' : 'hover:bg-slate-700 text-slate-300' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                消息管理
            </a>
            <a href="{{ route('admin.courses.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.courses.*') ? 'bg-teal-600 text-white' : 'hover:bg-slate-700 text-slate-300' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                課程管理
            </a>
            <a href="{{ route('admin.reservations.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin.reservations.*') ? 'bg-teal-600 text-white' : 'hover:bg-slate-700 text-slate-300' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                報名管理
            </a>
        </nav>
        <div class="px-3 py-4 border-t border-slate-700">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-slate-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                返回會員中心
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs text-slate-400 hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    登出
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Topbar --}}
        <header class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center justify-between">
            <h1 class="font-semibold text-slate-700 text-sm">@yield('page-title', '管理後台')</h1>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <div class="w-7 h-7 rounded-full bg-teal-100 text-teal-700 font-semibold text-xs flex items-center justify-center">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="text-xs">{{ auth()->user()->name }}</span>
            </div>
        </header>

        {{-- Flash messages --}}
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Content --}}
        <main class="flex-1 px-6 pb-8">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
