@extends('layouts.app')

@section('title', $course->title . ' — ' . config('app.name'))

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- Course Detail --}}
        <div class="lg:col-span-2">
            {{-- Breadcrumb --}}
            <nav class="text-xs text-slate-400 mb-5 flex items-center gap-1.5">
                <a href="{{ route('home') }}" class="hover:text-teal-600">首頁</a>
                <span>/</span>
                <a href="{{ route('courses.index') }}" class="hover:text-teal-600">課程列表</a>
                <span>/</span>
                <span class="text-slate-600 line-clamp-1">{{ $course->title }}</span>
            </nav>

            {{-- Status Badge --}}
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700">
                    {{ \App\Models\Course::statusLabel($course->status) }}
                </span>
                @if($course->credit_hours > 0)
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-teal-100 text-teal-700">
                        繼教時數 {{ $course->credit_hours }} 小時
                    </span>
                @endif
            </div>

            {{-- Title --}}
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 leading-snug mb-6">
                {{ $course->title }}
            </h1>

            {{-- Info Grid --}}
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 mb-8">
                <h2 class="text-sm font-semibold text-slate-600 uppercase tracking-wide mb-4">課程資訊</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($course->instructor)
                        <div>
                            <dt class="text-xs text-slate-400 mb-0.5">講師</dt>
                            <dd class="text-sm font-medium text-slate-800">{{ $course->instructor }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">上課時間</dt>
                        <dd class="text-sm font-medium text-slate-800">
                            {{ $course->start_at->format('Y/m/d H:i') }}
                            –
                            {{ $course->end_at->format('H:i') }}
                        </dd>
                    </div>
                    @if($course->location)
                        <div>
                            <dt class="text-xs text-slate-400 mb-0.5">地點</dt>
                            <dd class="text-sm font-medium text-slate-800">{{ $course->location }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">費用</dt>
                        <dd class="text-sm font-bold text-teal-700">
                            {{ $course->isFree() ? '免費參加' : 'NT$ ' . number_format($course->price) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">名額</dt>
                        <dd class="text-sm font-medium text-slate-800">
                            {{ $course->registered_count }} / {{ $course->max_participants }} 人
                            @if($course->isFull())
                                <span class="ml-2 text-xs text-red-500 font-semibold">（已額滿）</span>
                            @else
                                <span class="ml-2 text-xs text-teal-600">（尚餘 {{ $course->remainingSeats() }} 名）</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">繼教時數</dt>
                        <dd class="text-sm font-medium text-slate-800">{{ $course->credit_hours }} 小時</dd>
                    </div>
                </dl>
            </div>

            {{-- Description --}}
            @if($course->description)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-3">課程說明</h2>
                    <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                        {{ $course->description }}
                    </div>
                </div>
            @endif

            {{-- Back --}}
            <div class="pt-6 border-t border-slate-200">
                <a href="{{ route('courses.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-teal-600 transition-colors font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    返回課程列表
                </a>
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-5">

            {{-- Registration Card --}}
            <div class="bg-white rounded-2xl border-2 border-teal-200 p-6 sticky top-20">
                <div class="text-2xl font-bold text-teal-600 mb-1">
                    {{ $course->isFree() ? '免費' : 'NT$ ' . number_format($course->price) }}
                </div>
                @if(!$course->isFree())
                    <p class="text-xs text-slate-400 mb-4">每人報名費用</p>
                @else
                    <div class="mb-4"></div>
                @endif

                {{-- Seats Progress --}}
                <div class="mb-5">
                    <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                        <span>報名人數</span>
                        <span>{{ $course->registered_count }} / {{ $course->max_participants }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        @php $pct = $course->max_participants > 0 ? min(100, round($course->registered_count / $course->max_participants * 100)) : 0; @endphp
                        <div class="h-2 rounded-full {{ $pct >= 100 ? 'bg-red-400' : 'bg-teal-500' }} transition-all"
                             style="width: {{ $pct }}%"></div>
                    </div>
                </div>

                @if($course->isFull())
                    <div class="w-full bg-slate-100 text-slate-400 text-sm font-semibold text-center py-3 rounded-xl">
                        名額已滿
                    </div>
                @elseif(auth()->check())
                    @php
                        $myReservation = auth()->user()->reservations()
                            ->where('course_id', $course->id)
                            ->whereIn('status', ['pending','confirmed','attended'])
                            ->first();
                    @endphp
                    @if($myReservation)
                        <div class="w-full bg-green-50 border border-green-200 text-green-700 text-sm font-semibold text-center py-3 rounded-xl">
                            已報名（{{ \App\Models\Reservation::statusLabel($myReservation->status) }}）
                        </div>
                        @if(in_array($myReservation->status, ['pending','confirmed']))
                            <form method="POST" action="{{ route('reservations.cancel', $myReservation) }}"
                                  onsubmit="return confirm('確定取消報名？')" class="mt-2">
                                @csrf
                                <button type="submit" class="w-full text-xs text-red-500 hover:text-red-700 text-center py-1.5 transition-colors">
                                    取消報名
                                </button>
                            </form>
                        @endif
                    @else
                        <form method="POST" action="{{ route('reservations.store', $course) }}">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold py-3 rounded-xl transition-colors shadow-sm">
                                立即報名
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="block w-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold text-center py-3 rounded-xl transition-colors">
                        登入後報名
                    </a>
                    <p class="text-xs text-center text-slate-400 mt-2">
                        還沒有帳號？<a href="{{ route('register') }}" class="text-teal-600 hover:underline">免費註冊</a>
                    </p>
                @endif

                {{-- Key info summary --}}
                <ul class="mt-5 space-y-2.5 text-xs text-slate-500 border-t border-slate-100 pt-4">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $course->start_at->format('Y/m/d H:i') }}
                    </li>
                    @if($course->location)
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $course->location }}
                        </li>
                    @endif
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        繼教時數 {{ $course->credit_hours }} 小時
                    </li>
                </ul>
            </div>

            {{-- Need Help --}}
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-5 text-center">
                <p class="text-xs text-slate-500 mb-3">有課程相關問題？</p>
                <a href="mailto:service@socialwork.org.tw"
                   class="text-sm text-teal-600 font-medium hover:underline">
                    聯絡公會秘書處
                </a>
            </div>
        </aside>
    </div>
</div>

@endsection
