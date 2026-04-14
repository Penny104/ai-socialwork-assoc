@extends('layouts.app')

@section('title', '繼續教育課程 — ' . config('app.name'))

@section('content')

{{-- Page Header --}}
<div class="bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
        <nav class="text-xs text-slate-400 mb-3 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-teal-600">首頁</a>
            <span>/</span>
            <span class="text-slate-600">繼續教育課程</span>
        </nav>
        <h1 class="text-3xl font-bold text-slate-800">繼續教育課程</h1>
        <p class="text-slate-500 mt-2 text-sm">累積換照積分，精進專業知能</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

    @if($courses->isEmpty())
        <div class="text-center py-20 text-slate-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p>目前尚無開放課程</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <a href="{{ route('courses.show', $course) }}"
                   class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-md hover:border-teal-200 transition-all flex flex-col">
                    <div class="h-2 bg-gradient-to-r from-teal-500 to-cyan-400"></div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <h3 class="font-semibold text-slate-800 leading-snug group-hover:text-teal-700 transition-colors line-clamp-2 flex-1">
                                {{ $course->title }}
                            </h3>
                        </div>

                        <ul class="space-y-2 text-sm text-slate-500 mb-4 flex-1">
                            @if($course->instructor)
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $course->instructor }}
                                </li>
                            @endif
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $course->start_at->format('Y/m/d') }}
                                {{ $course->start_at->format('H:i') }} – {{ $course->end_at->format('H:i') }}
                            </li>
                            @if($course->location)
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $course->location }}
                                </li>
                            @endif
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                繼教時數 {{ $course->credit_hours }} 小時
                            </li>
                        </ul>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-teal-600 text-base">
                                    {{ $course->isFree() ? '免費' : 'NT$ ' . number_format($course->price) }}
                                </div>
                            </div>
                            <div class="text-right">
                                @if($course->isFull())
                                    <span class="text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full">名額已滿</span>
                                @else
                                    <span class="text-xs text-slate-500">剩 <strong class="text-slate-700">{{ $course->remainingSeats() }}</strong> 名</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($courses->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $courses->links() }}
            </div>
        @endif
    @endif
</div>

@endsection
