<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Submit a new booking request from Customer View.
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
                'status' => 'pending',
                'lead_photographer' => 'Ashan Rumaiz (Principal)',
                'notes' => $request->notes,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Thank you! Your booking request has been submitted successfully. We will be in touch shortly.',
                'data' => $booking,
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
