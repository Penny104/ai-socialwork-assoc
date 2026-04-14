<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\News;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $stats = [
            'users'        => User::count(),
            'news'         => News::count(),
            'courses'      => Course::count(),
            'reservations' => Reservation::count(),
            'pending'      => Reservation::where('status', 'pending')->count(),
        ];

        $latestReservations = Reservation::with(['user', 'course'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $openCourses = Course::where('status', 'open')
            ->orderBy('start_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestReservations', 'openCourses'));
    }

    protected function authorizeAdmin(Request $request): void
    {
        if (!$request->user()?->isAdmin()) {
            abort(403, '僅限管理員存取。');
        }
    }
}
