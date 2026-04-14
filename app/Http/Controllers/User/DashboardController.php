<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $reservations = $user->reservations()
            ->with('course')
            ->orderByDesc('created_at')
            ->get();

        return view('user.dashboard', compact('user', 'reservations'));
    }
}
