@extends('layouts.admin')

@section('title', '報名管理')
@section('page-title', '報名管理')

@section('content')

{{-- Filter --}}
<form method="GET" class="flex items-center gap-3 mb-5 flex-wrap">
    <select name="course_id"
            class="px-3 py-2 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white">
        <option value="">所有課程</option>
        @foreach($courses as $c)
            <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                {{ $c->title }}
            </option>
        @endforeach
    </select>
    <select name="status"
            class="px-3 py-2 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white">
        <option value="">所有狀態</option>
        <option value="pending"   {{ request('status')=='pending'?'selected':'' }}>待確認</option>
        <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>已確認</option>
        <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>已取消</option>
        <option value="attended"  {{ request('status')=='attended'?'selected':'' }}>已出席</option>
        <option value="no_show"   {{ request('status')=='no_show'?'selected':'' }}>未到場</option>
    </select>
    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-sm px-4 py-2 rounded-xl transition-colors">篩選</button>
    <a href="{{ route('admin.reservations.index') }}" class="text-sm text-slate-500 hover:underline">清除</a>
    <span class="ml-auto text-sm text-slate-500">共 {{ $reservations->total() }} 筆</span>
</form>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wide">
                <th class="px-5 py-3 text-left font-semibold">會員</th>
                <th class="px-5 py-3 text-left font-semibold">課程</th>
                <th class="px-5 py-3 text-left font-semibold">狀態</th>
                <th class="px-5 py-3 text-left font-semibold">繳費</th>
                <th class="px-5 py-3 text-left font-semibold">報名時間</th>
                <th class="px-5 py-3 text-left font-semibold">操作</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($reservations as $res)
                @php
                    $sc = ['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-teal-100 text-teal-700','cancelled'=>'bg-slate-100 text-slate-400','attended'=>'bg-green-100 text-green-700','no_show'=>'bg-red-100 text-red-500'];
                    $pc = ['unpaid'=>'text-orange-500','paid'=>'text-green-600','refunded'=>'text-slate-400','exempt'=>'text-teal-600'];
                    $pl = ['unpaid'=>'未付款','paid'=>'已付款','refunded'=>'已退款','exempt'=>'免費'];
                @endphp
                <tr>
                    <td class="px-5 py-3">
                        <div class="font-medium text-slate-700">{{ $res->user->name }}</div>
                        <div class="text-xs text-slate-400">{{ $res->user->email }}</div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="text-slate-700 line-clamp-1 max-w-[180px]">{{ $res->course->title }}</div>
                        <div class="text-xs text-slate-400">{{ $res->course->start_at->format('Y/m/d') }}</div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sc[$res->status] ?? '' }}">
                            {{ \App\Models\Reservation::statusLabel($res->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-xs {{ $pc[$res->payment_status] ?? '' }}">
                        {{ $pl[$res->payment_status] ?? $res->payment_status }}
                    </td>
                    <td class="px-5 py-3 text-xs text-slate-400">{{ $res->created_at->format('Y/m/d H:i') }}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2 flex-wrap">
                            @if($res->status === 'pending')
                                <form method="POST" action="{{ route('admin.reservations.confirm', $res) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-teal-600 hover:text-teal-800 font-medium">確認</button>
                                </form>
                            @endif
                            @if($res->status === 'confirmed')
                                <form method="POST" action="{{ route('admin.reservations.attend', $res) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-green-600 hover:text-green-800 font-medium">出席</button>
                                </form>
                                <form method="POST" action="{{ route('admin.reservations.noshow', $res) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-slate-500 hover:text-slate-700 font-medium">未到</button>
                                </form>
                            @endif
                            @if(in_array($res->status, ['pending','confirmed']))
                                <form method="POST" action="{{ route('admin.reservations.cancel', $res) }}"
                                      onsubmit="return confirm('確定取消此報名？')">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">取消</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-slate-400 py-10 text-sm">尚無報名記錄</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $reservations->links() }}</div>

@endsection
