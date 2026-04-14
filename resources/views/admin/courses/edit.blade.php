@extends('layouts.admin')

@section('title', '編輯課程')
@section('page-title', '編輯課程')

@section('content')

<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="space-y-5">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-5">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">課程名稱 <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">講師</label>
                    <input type="text" name="instructor" value="{{ old('instructor', $course->instructor) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">地點</label>
                    <input type="text" name="location" value="{{ old('location', $course->location) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">開始時間</label>
                    <input type="datetime-local" name="start_at"
                           value="{{ old('start_at', $course->start_at->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">結束時間</label>
                    <input type="datetime-local" name="end_at"
                           value="{{ old('end_at', $course->end_at->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">名額上限</label>
                    <input type="number" name="max_participants" value="{{ old('max_participants', $course->max_participants) }}" min="1"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">費用（NT$）</label>
                    <input type="number" name="price" value="{{ old('price', $course->price) }}" min="0" step="100"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">繼教時數</label>
                    <input type="number" name="credit_hours" value="{{ old('credit_hours', $course->credit_hours) }}" min="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">狀態</label>
                <select name="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white">
                    <option value="draft"      {{ old('status',$course->status)=='draft'?'selected':'' }}>草稿</option>
                    <option value="open"       {{ old('status',$course->status)=='open'?'selected':'' }}>開放報名</option>
                    <option value="closed"     {{ old('status',$course->status)=='closed'?'selected':'' }}>報名截止</option>
                    <option value="cancelled"  {{ old('status',$course->status)=='cancelled'?'selected':'' }}>已取消</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">課程說明</label>
                <textarea name="description" rows="5"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('description', $course->description) }}</textarea>
            </div>

            @if($course->status === 'cancelled')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">取消原因</label>
                    <input type="text" name="cancel_reason" value="{{ old('cancel_reason', $course->cancel_reason) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition-colors">
                儲存變更
            </button>
            <a href="{{ route('admin.courses.index') }}" class="text-sm text-slate-500 hover:text-slate-700">取消</a>
        </div>
    </form>
</div>

@endsection
