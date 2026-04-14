@extends('layouts.app')

@section('title', '會員登入 — ' . config('app.name'))

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-teal-600 text-white font-bold text-lg mb-4">
                社工
            </div>
            <h1 class="text-2xl font-bold text-slate-800">會員登入</h1>
            <p class="text-sm text-slate-500 mt-1">登入以報名課程及管理個人資料</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

            @if(session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5" for="email">電子郵件</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-300' }} text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                           placeholder="your@email.com">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5" for="password">密碼</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                           placeholder="••••••••">
                </div>

                {{-- Remember --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        記住我
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition-colors text-sm shadow-sm">
                    登入
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                還沒有帳號？
                <a href="{{ route('register') }}" class="text-teal-600 font-medium hover:underline">立即註冊</a>
            </p>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            測試帳號：admin@socialwork.org.tw / password
        </p>
    </div>
</div>
@endsection
