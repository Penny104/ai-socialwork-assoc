@extends('layouts.admin')

@section('title', '課程管理')
@section('page-title', '課程管理')

@section('content')

<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-slate-500">共 {{ $courses->total() }} 門課程</p>
    <a href="{{ route('admin.courses.create') }}"
       class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
        + 新增課程
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wide">
                <th class="px-5 py-3 text-left font-semibold">課程名稱</th>
                <th class="px-5 py-3 text-left font-semibold">時間</th>
                <th class="px-5 py-3 text-left font-semibold">狀態</th>
                <th class="px-5 py-3 text-left font-semibold">報名</th>
                <th class="px-5 py-3 text-left font-semibold">操作</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($courses as $course)
                @php
                    $sc = ['draft'=>'bg-slate-100 text-slate-500','open'=>'bg-green-100 text-green-700','closed'=>'bg-slate-100 text-slate-500','cancelled'=>'bg-red-100 text-red-500'];
                @endphp
                <tr class="{{ $course->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-5 py-3">
                        <div class="font-medium text-slate-800 line-clamp-1">{{ $course->title }}</div>
                        <div class="text-xs text-slate-400">{{ $course->instructor ?: '—' }} ｜ {{ $course->credit_hours }}h</div>
                    </td>
                    <td class="px-5 py-3 text-slate-500 text-xs">{{ $course->start_at->format('Y/m/d H:i') }}</td>
                    <td class="px-5 py-3">
                        @if($course->trashed())
                            <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-400">已刪除</span>
                        @else
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $sc[$course->status] ?? 'bg-slate-100 text-slate-400' }}">
                                {{ \App\Models\Course::statusLabel($course->status) }}
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-slate-600">{{ $course->registered_count }}/{{ $course->max_participants }}</td>
                    <td class="px-5 py-3">
                        @if(!$course->trashed())
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="text-teal-600 hover:underline text-xs">編輯</a>
                                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                                      onsubmit="return confirm('確定刪除此課程？')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs">刪除</button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-slate-400 py-10 text-sm">尚無課程</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $courses->links() }}</div>

@endsection
