<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private function authorizeAdmin(Request $request): void
    {
        if (!$request->user()?->isAdmin()) abort(403);
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $query = Reservation::with(['user', 'course']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->orderByDesc('created_at')->paginate(20);
        $courses = Course::orderByDesc('start_at')->get();

        return view('admin.reservations.index', compact('reservations', 'courses'));
    }

    public function confirm(Request $request, Reservation $reservation)
    {
        $this->authorizeAdmin($request);

        if ($reservation->status !== 'pending') {
            return back()->with('error', '只有「待確認」的報名可以確認。');
        }

        $reservation->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => $request->user()->id,
        ]);

        return back()->with('success', '已確認報名：' . $reservation->user->name);
    }

    public function cancel(Request $request, Reservation $reservation)
    {
        $this->authorizeAdmin($request);

        $request->validate(['cancel_reason' => ['nullable', 'string', 'max:200']]);

        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return back()->with('error', '此狀態無法取消。');
        }

        $reservation->update([
            'status'        => 'cancelled',
            'cancelled_at'  => now(),
            'cancelled_by'  => $request->user()->id,
            'cancel_reason' => $request->cancel_reason ?? '管理員取消',
        ]);

        $reservation->course->decrement('registered_count');

        return back()->with('success', '已取消報名。');
    }

    public function attend(Request $request, Reservation $reservation)
    {
        $this->authorizeAdmin($request);

        if ($reservation->status !== 'confirmed') {
            return back()->with('error', '只有「已確認」的報名可以標記出席。');
        }

        $reservation->update([
            'status'      => 'attended',
            'attended_at' => now(),
        ]);

        return back()->with('success', '已標記出席。');
    }

    public function noshow(Request $request, Reservation $reservation)
    {
        $this->authorizeAdmin($request);

        if ($reservation->status !== 'confirmed') {
            return back()->with('error', '只有「已確認」的報名可以標記未到。');
        }

        $reservation->update([
            'status'      => 'no_show',
            'no_show_at'  => now(),
        ]);

        return back()->with('success', '已標記未到。');
    }
}
