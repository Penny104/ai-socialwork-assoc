@extends('layouts.app')

@section('title', '會員中心 — ' . config('app.name'))

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-xl">
            {{ mb_substr($user->name, 0, 1) }}
        </div>
        <div>
            <h1 class="text-xl font-bold text-slate-800">{{ $user->name }}</h1>
            <p class="text-sm text-slate-500">{{ $user->email }}</p>
            @if($user->isAdmin())
                <span class="inline-block mt-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-orange-100 text-orange-700">管理員</span>
            @else
                <span class="inline-block mt-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-teal-100 text-teal-700">會員</span>
            @endif
        </div>
        @if($user->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
               class="ml-auto bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                進入管理後台
            </a>
        @endif
    </div>

    {{-- Profile Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <h2 class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">個人資料</h2>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-slate-400 text-xs">手機</dt>
                    <dd class="text-slate-700 font-medium">{{ $user->phone ?: '未填寫' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 text-xs">執照字號</dt>
                    <dd class="text-slate-700 font-medium">{{ $user->license_number ?: '未填寫' }}</dd>
                </div>
            </dl>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <h2 class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">報名統計</h2>
            <div class="text-3xl font-bold text-teal-600 mb-1">{{ $reservations->count() }}</div>
            <div class="text-xs text-slate-500">總報名次數</div>
            <div class="mt-3 text-sm text-slate-600">
                已出席：<span class="font-semibold text-green-600">{{ $reservations->where('status','attended')->count() }}</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <h2 class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">繼教時數</h2>
            <div class="text-3xl font-bold text-teal-600 mb-1">
                {{ $reservations->where('status','attended')->sum(fn($r) => $r->course->credit_hours ?? 0) }}
            </div>
            <div class="text-xs text-slate-500">累積出席時數</div>
        </div>
    </div>

    {{-- Reservations --}}
    <div class="bg-white rounded-2xl border border-slate-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">我的報名記錄</h2>
            <a href="{{ route('courses.index') }}"
               class="text-sm text-teal-600 font-medium hover:underline">瀏覽課程</a>
        </div>

        @if($reservations->isEmpty())
            <div class="text-center py-16 text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm">尚無報名記錄</p>
                <a href="{{ route('courses.index') }}" class="mt-3 inline-block text-sm text-teal-600 font-medium hover:underline">立即報名課程</a>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($reservations as $res)
                    @php
                        $statusColors = [
                            'pending'   => 'bg-yellow-100 text-yellow-700',
                            'confirmed' => 'bg-teal-100 text-teal-700',
                            'cancelled' => 'bg-slate-100 text-slate-500',
                            'attended'  => 'bg-green-100 text-green-700',
                            'no_show'   => 'bg-red-100 text-red-600',
                        ];
                        $statusColor = $statusColors[$res->status] ?? 'bg-slate-100 text-slate-500';
                    @endphp
                    <div class="px-6 py-4 flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('courses.show', $res->course) }}"
                               class="font-medium text-slate-800 hover:text-teal-600 transition-colors text-sm leading-snug line-clamp-1">
                                {{ $res->course->title }}
                            </a>
                            <div class="flex items-center gap-3 mt-1.5 text-xs text-slate-400">
                                <span>{{ $res->course->start_at->format('Y/m/d H:i') }}</span>
                                @if($res->course->location)
                                    <span>{{ $res->course->location }}</span>
                                @endif
                                <span>繼教 {{ $res->course->credit_hours }}h</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColor }}">
                                {{ \App\Models\Reservation::statusLabel($res->status) }}
                            </span>
                            @if(in_array($res->status, ['pending', 'confirmed']))
                                <form method="POST" action="{{ route('reservations.cancel', $res) }}"
                                      onsubmit="return confirm('確定要取消此報名嗎？')">
                                    @csrf
                                    <button type="submit"
                                            class="text-xs text-red-500 hover:text-red-700 font-medium transition-colors">
                                        取消報名
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
