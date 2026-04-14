@extends('layouts.admin')

@section('title', '控制台')
@section('page-title', '控制台')

@section('content')

{{-- Stats Grid --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    @foreach([
        ['label'=>'會員總數',   'value'=>$stats['users'],        'color'=>'text-blue-600',   'bg'=>'bg-blue-50'],
        ['label'=>'消息總數',   'value'=>$stats['news'],         'color'=>'text-purple-600', 'bg'=>'bg-purple-50'],
        ['label'=>'課程總數',   'value'=>$stats['courses'],      'color'=>'text-teal-600',   'bg'=>'bg-teal-50'],
        ['label'=>'總報名數',   'value'=>$stats['reservations'], 'color'=>'text-green-600',  'bg'=>'bg-green-50'],
        ['label'=>'待確認報名', 'value'=>$stats['pending'],      'color'=>'text-orange-600', 'bg'=>'bg-orange-50'],
    ] as $stat)
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            <div class="text-xs text-slate-500 mt-1">{{ $stat['label'] }}</div>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Latest Reservations --}}
    <div class="bg-white rounded-2xl border border-slate-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-sm text-slate-700">最新報名</h2>
            <a href="{{ route('admin.reservations.index') }}" class="text-xs text-teal-600 hover:underline">查看全部</a>
        </div>
        @if($latestReservations->isEmpty())
            <p class="text-center text-slate-400 text-sm py-8">尚無報名記錄</p>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($latestReservations as $res)
                    @php
                        $sc = ['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-teal-100 text-teal-700','cancelled'=>'bg-slate-100 text-slate-400','attended'=>'bg-green-100 text-green-700','no_show'=>'bg-red-100 text-red-500'];
                    @endphp
                    <div class="px-5 py-3 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-slate-700 truncate">{{ $res->user->name }}</div>
                            <div class="text-xs text-slate-400 truncate">{{ $res->course->title }}</div>
                        </div>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sc[$res->status] ?? 'bg-slate-100 text-slate-400' }} shrink-0">
                            {{ \App\Models\Reservation::statusLabel($res->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Open Courses --}}
    <div class="bg-white rounded-2xl border border-slate-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-sm text-slate-700">開放中的課程</h2>
            <a href="{{ route('admin.courses.index') }}" class="text-xs text-teal-600 hover:underline">查看全部</a>
        </div>
        @if($openCourses->isEmpty())
            <p class="text-center text-slate-400 text-sm py-8">目前無開放課程</p>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($openCourses as $course)
                    <div class="px-5 py-3 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-slate-700 truncate">{{ $course->title }}</div>
                            <div class="text-xs text-slate-400">{{ $course->start_at->format('Y/m/d') }}</div>
                        </div>
                        <div class="text-xs text-slate-500 shrink-0">
                            {{ $course->registered_count }}/{{ $course->max_participants }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
