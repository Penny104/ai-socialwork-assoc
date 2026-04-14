<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// ---------- Public ----------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// ---------- Admin Login (hidden from public nav) ----------
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ---------- Admin Backend ----------
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('news',    Admin\NewsController::class);
    Route::resource('courses', Admin\CourseController::class);

    Route::get( 'reservations',                       [Admin\ReservationController::class, 'index'])  ->name('reservations.index');
    Route::post('reservations/{reservation}/confirm', [Admin\ReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::post('reservations/{reservation}/cancel',  [Admin\ReservationController::class, 'cancel']) ->name('reservations.cancel');
    Route::post('reservations/{reservation}/attend',  [Admin\ReservationController::class, 'attend']) ->name('reservations.attend');
    Route::post('reservations/{reservation}/noshow',  [Admin\ReservationController::class, 'noshow']) ->name('reservations.noshow');

    // Booking requests management
    Route::get( 'bookings',                     [\App\Http\Controllers\Admin\BookingAdminController::class, 'index'])  ->name('bookings.index');
    Route::post('bookings/{booking}/confirm',   [\App\Http\Controllers\Admin\BookingAdminController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{booking}/cancel',    [\App\Http\Controllers\Admin\BookingAdminController::class, 'cancel']) ->name('bookings.cancel');
});
