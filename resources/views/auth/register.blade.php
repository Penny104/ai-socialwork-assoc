@extends('layouts.app')

@section('title', '會員註冊 — ' . config('app.name'))

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-teal-600 text-white font-bold text-lg mb-4">
                社工
            </div>
            <h1 class="text-2xl font-bold text-slate-800">會員註冊</h1>
            <p class="text-sm text-slate-500 mt-1">建立帳號以報名繼續教育課程</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5" for="name">姓名 <span class="text-red-400">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                           placeholder="王小明">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5" for="email">電子郵件 <span class="text-red-400">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                           placeholder="your@email.com">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5" for="phone">手機號碼</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                           placeholder="0912-345-678">
                </div>

                {{-- License Number --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5" for="license_number">社工師執照字號</label>
                    <input id="license_number" type="text" name="license_number" value="{{ old('license_number') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                           placeholder="社字第000000號">
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5" for="password">密碼 <span class="text-red-400">*</span></label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-slate-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                           placeholder="至少 8 個字元">
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Confirm --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5" for="password_confirmation">確認密碼 <span class="text-red-400">*</span></label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                           placeholder="再次輸入密碼">
                </div>

                <button type="submit"
                        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition-colors text-sm shadow-sm">
                    建立帳號
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                已有帳號？
                <a href="{{ route('login') }}" class="text-teal-600 font-medium hover:underline">立即登入</a>
            </p>
        </div>
    </div>
</div>
@endsection
