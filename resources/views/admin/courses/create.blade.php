@extends('layouts.admin')

@section('title', '新增課程')
@section('page-title', '新增課程')

@section('content')

<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-5">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-5">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">課程名稱 <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">講師</label>
                    <input type="text" name="instructor" value="{{ old('instructor') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">地點</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">開始時間 <span class="text-red-400">*</span></label>
                    <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('start_at') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">結束時間 <span class="text-red-400">*</span></label>
                    <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    @error('end_at') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">名額上限</label>
                    <input type="number" name="max_participants" value="{{ old('max_participants', 30) }}" min="1"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">費用（NT$）</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="100"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">繼教時數</label>
                    <input type="number" name="credit_hours" value="{{ old('credit_hours', 3) }}" min="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">狀態</label>
                <select name="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white">
                    <option value="draft" {{ old('status')=='draft'?'selected':'' }}>草稿</option>
                    <option value="open"  {{ old('status')=='open'?'selected':'' }}>開放報名</option>
                    <option value="closed" {{ old('status')=='closed'?'selected':'' }}>報名截止</option>
                    <option value="cancelled" {{ old('status')=='cancelled'?'selected':'' }}>已取消</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">課程說明</label>
                <textarea name="description" rows="5"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition-colors">
                建立課程
            </button>
            <a href="{{ route('admin.courses.index') }}" class="text-sm text-slate-500 hover:text-slate-700">取消</a>
        </div>
    </form>
</div>

@endsection
