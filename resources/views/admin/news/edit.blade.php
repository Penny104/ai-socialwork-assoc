@extends('layouts.admin')

@section('title', '編輯消息')
@section('page-title', '編輯消息')

@section('content')

<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.news.update', $news) }}" class="space-y-5">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-5">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">標題 <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title', $news->title) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">分類</label>
                <select name="category"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white">
                    <option value="announcement" {{ old('category',$news->category)=='announcement'?'selected':'' }}>公告</option>
                    <option value="activity"     {{ old('category',$news->category)=='activity'?'selected':'' }}>活動</option>
                    <option value="welfare"      {{ old('category',$news->category)=='welfare'?'selected':'' }}>福利</option>
                    <option value="other"        {{ old('category',$news->category)=='other'?'selected':'' }}>其他</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">摘要</label>
                <textarea name="excerpt" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none">{{ old('excerpt', $news->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">內文 <span class="text-red-400">*</span></label>
                <textarea name="content" rows="10" required
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('content', $news->content) }}</textarea>
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1"
                           {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                           class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    已發布
                </label>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">發布日期</label>
                    <input type="datetime-local" name="published_at"
                           value="{{ old('published_at', $news->published_at?->format('Y-m-d\TH:i')) }}"
                           class="px-3 py-1.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition-colors">
                儲存變更
            </button>
            <a href="{{ route('admin.news.index') }}" class="text-sm text-slate-500 hover:text-slate-700">取消</a>
        </div>
    </form>
</div>

@endsection
