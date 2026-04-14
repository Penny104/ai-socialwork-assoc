@extends('layouts.admin')

@section('title', '消息管理')
@section('page-title', '消息管理')

@section('content')

<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-slate-500">共 {{ $news->total() }} 則消息</p>
    <a href="{{ route('admin.news.create') }}"
       class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
        + 新增消息
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wide">
                <th class="px-5 py-3 text-left font-semibold">標題</th>
                <th class="px-5 py-3 text-left font-semibold">分類</th>
                <th class="px-5 py-3 text-left font-semibold">狀態</th>
                <th class="px-5 py-3 text-left font-semibold">發布日期</th>
                <th class="px-5 py-3 text-left font-semibold">操作</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($news as $item)
                <tr class="{{ $item->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-5 py-3">
                        <div class="font-medium text-slate-800 line-clamp-1">{{ $item->title }}</div>
                        <div class="text-xs text-slate-400">瀏覽 {{ $item->view_count }} 次</div>
                    </td>
                    <td class="px-5 py-3 text-slate-500">{{ \App\Models\News::categoryLabel($item->category) }}</td>
                    <td class="px-5 py-3">
                        @if($item->trashed())
                            <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-400">已刪除</span>
                        @elseif($item->is_published)
                            <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">已發布</span>
                        @else
                            <span class="text-xs px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">草稿</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-slate-500">{{ $item->published_at?->format('Y/m/d') ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @if(!$item->trashed())
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.news.edit', $item) }}" class="text-teal-600 hover:underline text-xs">編輯</a>
                                <form method="POST" action="{{ route('admin.news.destroy', $item) }}"
                                      onsubmit="return confirm('確定刪除此消息？')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs">刪除</button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-slate-400 py-10 text-sm">尚無消息</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $news->links() }}</div>

@endsection
