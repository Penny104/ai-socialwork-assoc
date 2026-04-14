<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = $request->user();

        // 檢查課程是否開放
        if ($course->status !== 'open') {
            return back()->with('error', '此課程目前不開放報名。');
        }

        // 檢查是否已額滿
        if ($course->isFull()) {
            return back()->with('error', '此課程名額已滿，無法報名。');
        }

        // 檢查是否已報名
        $exists = Reservation::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereIn('status', ['pending', 'confirmed', 'attended'])
            ->exists();

        if ($exists) {
            return back()->with('error', '您已報名此課程，請勿重複報名。');
        }

        DB::transaction(function () use ($user, $course) {
            Reservation::create([
                'user_id'         => $user->id,
                'course_id'       => $course->id,
                'status'          => 'pending',
                'payment_status'  => $course->isFree() ? 'exempt' : 'unpaid',
            ]);

            $course->increment('registered_count');
        });

        return back()->with('success', '報名成功！待工作人員確認後，您將收到通知。');
    }

    public function cancel(Request $request, Reservation $reservation)
    {
        $user = $request->user();

        // 只能取消自己的報名
        if ($reservation->user_id !== $user->id) {
            abort(403);
        }

        // 只能取消 pending 或 confirmed 狀態
        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return back()->with('error', '此報名記錄無法取消。');
        }

        DB::transaction(function () use ($reservation, $user) {
            $reservation->update([
                'status'       => 'cancelled',
                'cancelled_at' => now(),
                'cancelled_by' => $user->id,
                'cancel_reason'=> '會員自行取消',
            ]);

            $reservation->course->decrement('registered_count');
        });

        return back()->with('success', '已成功取消報名。');
    }
}
