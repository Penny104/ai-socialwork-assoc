@extends('layouts.admin')

@section('title', '新增消息')
@section('page-title', '新增消息')

@section('content')

<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.news.store') }}" class="space-y-5">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-5">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">標題 <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('title') ? 'border-red-400' : 'border-slate-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">分類 <span class="text-red-400">*</span></label>
                <select name="category" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white">
                    <option value="announcement" {{ old('category')=='announcement'?'selected':'' }}>公告</option>
                    <option value="activity"     {{ old('category')=='activity'?'selected':'' }}>活動</option>
                    <option value="welfare"      {{ old('category')=='welfare'?'selected':'' }}>福利</option>
                    <option value="other"        {{ old('category')=='other'?'selected':'' }}>其他</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">摘要</label>
                <textarea name="excerpt" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none"
                          placeholder="簡短說明（顯示於列表頁）">{{ old('excerpt') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">內文 <span class="text-red-400">*</span></label>
                <textarea name="content" rows="10" required
                          class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('content') ? 'border-red-400' : 'border-slate-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('content') }}</textarea>
                @error('content') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                           class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    立即發布
                </label>
                <div>
                    <label class="block text-xs text-slate-500 mb-1">發布日期（選填）</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
                           class="px-3 py-1.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition-colors">
                建立消息
            </button>
            <a href="{{ route('admin.news.index') }}" class="text-sm text-slate-500 hover:text-slate-700">取消</a>
        </div>
    </form>
</div>

@endsection
