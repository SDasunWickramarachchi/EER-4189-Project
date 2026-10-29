<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;

// Web Routes
Route::get('/', function () {
    return view('home');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/booking', function () {
    return view('booking');
});

Route::get('/portfolio', function () {
    return view('portfolio');
});

// Admin pages
Route::get('/admin', function () {
    return redirect('/admin/booking');
});

Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::get('/admin/forgot-password', function () {
    return view('admin.forgot-password');
});

Route::get('/admin/services', function () {
    return view('admin.services');
});

Route::get('/admin/booking', function () {
    return view('admin.booking');
});

// API Routes (MongoDB Integrated)
Route::prefix('api')->group(function () {
    // Services Endpoints
    Route::get('/services', [ServiceController::class, 'publicIndex']);

    // =========================================================================
    // 👩‍💻 [TEAMMATE AREA - FEATURE 1]: Availability Engine & Busy Dates
    // Assigned to: Teammate
    // Scope: Check availability for date/slots and fetch booked calendar dates
    // =========================================================================
    Route::get('/bookings/availability', [BookingController::class, 'checkAvailability']);
    Route::get('/bookings/busy-dates', [BookingController::class, 'getBusyDates']);

    // =========================================================================
    // 👨‍💻 [LEAD AREA - FEATURE 2]: Booking Submission, Pending Workflow & Confirmation
    // Assigned to: Lead (You)
    // Scope: Customer booking submission, 'pending' status enforcement, reference number
    // =========================================================================
    Route::post('/bookings', [BookingController::class, 'storeCustomerBooking']);

    // Admin Management Endpoints
    Route::prefix('admin')->group(function () {
        // Services Management
        Route::get('/services', [ServiceController::class, 'adminIndex']);
        Route::post('/services', [ServiceController::class, 'store']);
        Route::get('/services/{id}', [ServiceController::class, 'show']);
        Route::post('/services/{id}', [ServiceController::class, 'update']);
        Route::put('/services/{id}', [ServiceController::class, 'update']);
        Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

        // Bookings Management
        Route::get('/bookings', [BookingController::class, 'adminIndex']);
        Route::post('/bookings', [BookingController::class, 'adminStore']);
        Route::get('/bookings/{id}', [BookingController::class, 'show']);
        Route::post('/bookings/{id}', [BookingController::class, 'update']);
        Route::put('/bookings/{id}', [BookingController::class, 'update']);
        Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
    });
});
