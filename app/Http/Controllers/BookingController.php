<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution_name' => ['required', 'string', 'max:100'],
            'requested_date'   => ['required', 'date', 'after:today'],
            'teaching_hours'   => ['nullable', 'string', 'max:100'],
            'location'         => ['nullable', 'string', 'max:200'],
            'expectations'     => ['nullable', 'string', 'max:1000'],
            'contact_phone'    => ['nullable', 'string', 'max:30'],
            'contact_email'    => ['required', 'email', 'max:150'],
        ], [
            'institution_name.required' => '請填寫機構名稱。',
            'requested_date.required'   => '請選擇申請日期。',
            'requested_date.after'      => '日期必須為今日之後。',
            'contact_email.required'    => '請填寫聯絡 Email。',
            'contact_email.email'       => 'Email 格式不正確。',
        ]);

        BookingRequest::create($validated);

        return back()->with('success', '預約申請已送出！我們將盡快與您聯絡確認詳情。');
    }
}
