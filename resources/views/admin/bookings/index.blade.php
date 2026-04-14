@extends('layouts.admin')
@section('title', '預約申請管理')
@section('page-title', '預約申請管理')

@section('content')

<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-slate-500">共 {{ $bookings->total() }} 筆申請</p>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wide">
                <th class="px-5 py-3 text-left font-semibold">機構名稱</th>
                <th class="px-5 py-3 text-left font-semibold">申請日期</th>
                <th class="px-5 py-3 text-left font-semibold">地點</th>
                <th class="px-5 py-3 text-left font-semibold">聯絡方式</th>
                <th class="px-5 py-3 text-left font-semibold">狀態</th>
                <th class="px-5 py-3 text-left font-semibold">操作</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($bookings as $b)
                @php
                    $sc = ['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-teal-100 text-teal-700','cancelled'=>'bg-slate-100 text-slate-400'];
                @endphp
                <tr>
                    <td class="px-5 py-3">
                        <div class="font-medium text-slate-800">{{ $b->institution_name }}</div>
                        @if($b->teaching_hours)
                            <div class="text-xs text-slate-400">{{ $b->teaching_hours }}</div>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-slate-600">{{ $b->requested_date->format('Y/m/d') }}</td>
                    <td class="px-5 py-3 text-slate-500 text-xs">{{ $b->location ?: '—' }}</td>
                    <td class="px-5 py-3 text-xs text-slate-500">
                        <div>{{ $b->contact_email }}</div>
                        @if($b->contact_phone) <div>{{ $b->contact_phone }}</div> @endif
                    </td>
                    <td class="px-5 py-3">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sc[$b->status] ?? '' }}">
                            {{ \App\Models\BookingRequest::statusLabel($b->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            @if($b->status === 'pending')
                                <form method="POST" action="{{ route('admin.bookings.confirm', $b) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-teal-600 hover:text-teal-800 font-medium">確認</button>
                                </form>
                            @endif
                            @if($b->status !== 'cancelled')
                                <form method="POST" action="{{ route('admin.bookings.cancel', $b) }}"
                                      onsubmit="return confirm('確定取消此申請？')">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">取消</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-slate-400 py-10 text-sm">尚無預約申請</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $bookings->links() }}</div>

@endsection
