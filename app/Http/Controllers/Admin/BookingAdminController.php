<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingRequest;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    private function auth(Request $request): void
    {
        if (!$request->user()?->isAdmin()) abort(403);
    }

    public function index(Request $request)
    {
        $this->auth($request);
        $bookings = BookingRequest::orderByDesc('created_at')->paginate(20);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function confirm(Request $request, BookingRequest $booking)
    {
        $this->auth($request);
        $booking->update(['status' => 'confirmed']);
        return back()->with('success', '已確認預約申請。');
    }

    public function cancel(Request $request, BookingRequest $booking)
    {
        $this->auth($request);
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', '已取消預約申請。');
    }
}
