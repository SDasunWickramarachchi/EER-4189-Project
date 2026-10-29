<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * =========================================================================
     * [FEATURE 1 - ALLOCATED TO TEAMMATE]: Availability Engine & Busy Dates
     * =========================================================================
     *
     * Check date and slot availability for a prospective session.
     * GET /api/bookings/availability?date=YYYY-MM-DD
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $requestedDate = $request->query('date');

            // Find existing confirmed or pending bookings on that date
            $existingBookings = Booking::where('session_date', $requestedDate)
                ->whereIn('status', ['confirmed', 'pending', 'awaiting_retainer'])
                ->get();

            $isBooked = $existingBookings->count() >= 2; // Studio max 2 sessions per day threshold
            $slotsAvailable = [
                [
                    'slot' => 'Morning (09:00 AM - 01:00 PM)',
                    'available' => !$existingBookings->contains(function ($b) {
                        return str_contains(strtolower($b->start_time ?? ''), '09:') || str_contains(strtolower($b->start_time ?? ''), '10:');
                    })
                ],
                [
                    'slot' => 'Golden Hour / Evening (02:30 PM - 06:30 PM)',
                    'available' => !$existingBookings->contains(function ($b) {
                        return str_contains(strtolower($b->start_time ?? ''), '01:') || str_contains(strtolower($b->start_time ?? ''), '02:') || str_contains(strtolower($b->start_time ?? ''), '03:');
                    })
                ]
            ];

            return response()->json([
                'status' => 'success',
                'date' => $requestedDate,
                'available' => !$isBooked,
                'booking_count' => $existingBookings->count(),
                'slots' => $slotsAvailable,
                'message' => $isBooked
                    ? 'This date is already fully booked. Please choose an alternate date.'
                    : 'Date is available for reservation.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to check availability: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get list of unavailable / booked dates for calendar disabling.
     * GET /api/bookings/busy-dates?month=YYYY-MM
     */
    public function getBusyDates(Request $request): JsonResponse
    {
        try {
            $month = $request->query('month', date('Y-m'));

            $bookings = Booking::where('session_date', 'like', "{$month}%")
                ->whereIn('status', ['confirmed', 'awaiting_retainer'])
                ->get();

            // Group dates with 2 or more shoots as fully booked
            $dateCounts = $bookings->groupBy('session_date')->map->count();
            $busyDates = $dateCounts->filter(fn($count) => $count >= 2)->keys()->values();

            return response()->json([
                'status' => 'success',
                'month' => $month,
                'busy_dates' => $busyDates,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch busy dates: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * =========================================================================
     * [FEATURE 2 - ALLOCATED TO LEAD]: Booking Submission, Pending Workflow & Confirmation
     * =========================================================================
     *
     * Submit a new booking request from Customer View.
     * Always enforced as 'pending' with studio SLA, reference code, and confirmation payload.
     * POST /api/bookings
     */
    public function storeCustomerBooking(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:50',
            'client_email' => 'required|email|max:255',
            'session_date' => 'required|date',
            'session_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_time' => 'nullable|string|max:50',
            'end_time' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Please correct the highlighted fields.'
            ], 422);
        }

        try {
            // Strictly enforce status as 'pending' for customer submissions
            $booking = Booking::create([
                'client_name' => trim($request->client_name),
                'client_phone' => trim($request->client_phone),
                'client_email' => trim($request->client_email),
                'session_date' => $request->session_date,
                'start_time' => $request->input('start_time', '10:00 AM'),
                'end_time' => $request->input('end_time', '05:00 PM'),
                'session_type' => $request->session_type,
                'location' => trim($request->location),
                'status' => 'pending',
                'lead_photographer' => 'Ashan Rumaiz (Principal)',
                'notes' => $request->input('notes'),
            ]);

            // Construct rich confirmation packet for the client
            $confirmation = [
                'reference_number' => $booking->reference_number,
                'status' => 'pending',
                'status_label' => 'Pending Studio Review',
                'client_name' => $booking->client_name,
                'client_email' => $booking->client_email,
                'client_phone' => $booking->client_phone,
                'session_date' => $booking->session_date,
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
                'session_type' => $booking->session_type,
                'location' => $booking->location,
                'lead_photographer' => $booking->lead_photographer,
                'notes' => $booking->notes,
                'review_timeframe' => 'Within 24 Hours',
                'submitted_at' => now()->toIso8601String(),
                'next_steps' => [
                    'Step 1: Calendar Reservation — Your requested shoot date is logged in our studio queue.',
                    'Step 2: Studio Verification — Ashan Rumaiz reviews the session schedule, timing, and venue logistics within 24 hours.',
                    'Step 3: Formal Confirmation & Retainer — You will receive an official approval email with the 50% retainer invoice and contract to lock the date.',
                    'Step 4: Creative Consultation — 1 week prior to the session, we conduct a pre-shoot consultation for wardrobe and shot list planning.'
                ],
                'studio_support' => [
                    'contact_person' => 'Ashan Rumaiz (Principal Photographer)',
                    'phone' => '+94 77 444 8255',
                    'email' => 'ashanrumaiz@gmail.com',
                    'studio_address' => 'No.07/20, Rainbow Village, Mahahunupitiya, Negombo, Sri Lanka'
                ]
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Thank you! Your booking request has been submitted successfully and is now Pending Review.',
                'data' => $booking,
                'confirmation' => $confirmation,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit booking request: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get bookings list & summary statistics for Admin Dashboard.
     * GET /api/admin/bookings
     */
    public function adminIndex(Request $request): JsonResponse
    {
        try {
            $query = Booking::query();

            // Status filter (e.g., 'confirmed', 'pending', 'completed', 'cancelled', 'awaiting_retainer')
            if ($request->has('status') && $request->status !== 'all') {
                $query->where('status', strtolower($request->status));
            }

            // Search filter (client name, email, location)
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('client_name', 'like', "%{$search}%")
                      ->orWhere('client_email', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }

            // Service / Session Type filter
            if ($request->has('session_type') && !empty($request->session_type) && $request->session_type !== 'All Specialties') {
                $query->where('session_type', $request->session_type);
            }

            // Fetch filtered results
            $bookings = $query->orderBy('session_date', 'desc')->get();

            // Compute summary statistics for admin header metrics
            $allBookings = Booking::all();
            $stats = [
                'total_bookings' => $allBookings->count(),
                'confirmed_shoots' => $allBookings->where('status', 'confirmed')->count(),
                'awaiting_retainer' => $allBookings->where('status', 'awaiting_retainer')->count(),
                'counts_by_status' => [
                    'all' => $allBookings->count(),
                    'confirmed' => $allBookings->where('status', 'confirmed')->count(),
                    'pending' => $allBookings->where('status', 'pending')->count(),
                    'rejected' => $allBookings->where('status', 'rejected')->count(),
                    'completed' => $allBookings->where('status', 'completed')->count(),
                    'cancelled' => $allBookings->where('status', 'cancelled')->count(),
                    'awaiting_retainer' => $allBookings->where('status', 'awaiting_retainer')->count(),
                ]
            ];

            return response()->json([
                'status' => 'success',
                'stats' => $stats,
                'data' => $bookings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch bookings: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a booking directly from Admin Panel.
     * POST /api/admin/bookings
     */
    public function adminStore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:50',
            'client_email' => 'required|email|max:255',
            'session_date' => 'required|date',
            'session_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed,awaiting_retainer,completed,cancelled,rejected',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'lead_photographer' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $booking = Booking::create([
                'client_name' => $request->client_name,
                'client_phone' => $request->client_phone,
                'client_email' => $request->client_email,
                'session_date' => $request->session_date,
                'start_time' => $request->input('start_time', '10:00 AM'),
                'end_time' => $request->input('end_time', '05:00 PM'),
                'session_type' => $request->session_type,
                'location' => $request->location,
                'status' => $request->status,
                'lead_photographer' => $request->input('lead_photographer', 'Ashan Rumaiz (Principal)'),
                'notes' => $request->notes,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Booking created successfully',
                'data' => $booking,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create booking: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Fetch a single booking for viewing/editing.
     * GET /api/admin/bookings/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $booking = Booking::find($id);

            if (!$booking) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Booking not found',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $booking,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch booking: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing booking (e.g. status change, date, details).
     * POST/PUT /api/admin/bookings/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $booking = Booking::find($id);

            if (!$booking) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Booking not found',
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'client_name' => 'sometimes|required|string|max:255',
                'client_phone' => 'sometimes|required|string|max:50',
                'client_email' => 'sometimes|required|email|max:255',
                'session_date' => 'sometimes|required|date',
                'session_type' => 'sometimes|required|string|max:255',
                'location' => 'sometimes|required|string|max:255',
                'status' => 'sometimes|required|in:pending,confirmed,awaiting_retainer,completed,cancelled,rejected',
                'start_time' => 'nullable|string',
                'end_time' => 'nullable|string',
                'lead_photographer' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $booking->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Booking updated successfully',
                'data' => $booking->fresh(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update booking: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a booking.
     * DELETE /api/admin/bookings/{id}
     */
    public function destroy($id): JsonResponse
    {
        try {
            $booking = Booking::find($id);

            if (!$booking) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Booking not found',
                ], 404);
            }

            $booking->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Booking deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete booking: ' . $e->getMessage(),
            ], 500);
        }
    }
}
