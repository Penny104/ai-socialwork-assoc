<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:50'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'license_number' => ['nullable', 'string', 'max:30'],
            'password'       => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => '請輸入姓名。',
            'email.required'     => '請輸入電子郵件。',
            'email.unique'       => '此電子郵件已被使用。',
            'password.min'       => '密碼至少需要 8 個字元。',
            'password.confirmed' => '兩次輸入的密碼不一致。',
        ]);

        $user = User::create([
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'] ?? null,
            'license_number' => $validated['license_number'] ?? null,
            'password'       => Hash::make($validated['password']),
            'role'           => 'member',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', '註冊成功！歡迎加入台灣社工師公會管理系統。');
    }
}
