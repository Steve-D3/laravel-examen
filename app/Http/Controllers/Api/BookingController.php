<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(): JsonResponse
    {
        $bookings = Booking::with('trip:id,title,start_date')->get();

        return response()->json($bookings);
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(BookingRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            // Get the trip with lock to prevent overbooking
            $trip = Trip::where('id', $request->trip_id)
                ->where('is_available', true)
                ->where('start_date', '>', now())
                ->lockForUpdate()
                ->firstOrFail();

            // Check availability
            $totalBooked = Booking::where('trip_id', $trip->id)
                ->where('status', 'confirmed')
                ->sum('participants');

            if (($totalBooked + $request->participants) > $trip->max_participants) {
                return response()->json([
                    'message' => 'Not enough available spots for this trip',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Calculate total price
            $totalPrice = $trip->price_per_person * $request->participants;

            // Create the booking
            $booking = new Booking($request->validated());
            $booking->total_price = $totalPrice;
            $booking->status = 'confirmed'; // API bookings are confirmed by default
            $booking->save();

            // Return the created booking with 201 status
            return response()->json([
                'message' => 'Booking created successfully',
                'data' => $booking->load('trip')
            ], Response::HTTP_CREATED);
        });
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking): JsonResponse
    {
        return response()->json([
            'data' => $booking->load('trip')
        ]);
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(BookingRequest $request, Booking $booking): JsonResponse
    {
        return DB::transaction(function () use ($request, $booking) {
            $trip = $booking->trip_id != $request->trip_id
                ? Trip::findOrFail($request->trip_id)
                : $booking->trip;

            // Check if we need to verify capacity (trip changed or participants increased)
            if ($booking->trip_id != $request->trip_id || $request->participants > $booking->participants) {
                $totalBooked = Booking::where('trip_id', $trip->id)
                    ->where('status', 'confirmed')
                    ->where('id', '!=', $booking->id)
                    ->sum('participants');

                $availableSpots = $trip->max_participants - $totalBooked;

                if ($request->participants > $availableSpots) {
                    return response()->json([
                        'message' => 'Not enough available spots for this trip',
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }

            // Update booking
            $booking->fill($request->validated());

            // Recalculate price if trip or participants changed
            if ($booking->isDirty(['trip_id', 'participants'])) {
                $booking->total_price = $trip->price_per_person * $booking->participants;
            }

            $booking->save();

            return response()->json([
                'message' => 'Booking updated successfully',
                'data' => $booking->load('trip')
            ]);
        });
    }

    /**
     * Remove the specified booking from storage.
     */
    public function destroy(Booking $booking): JsonResponse
    {
        // Only allow deleting future trips or provide cancellation instead
        if ($booking->trip->start_date < now()) {
            return response()->json([
                'message' => 'Cannot delete booking for past trips. Please cancel instead.',
            ], Response::HTTP_FORBIDDEN);
        }

        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully'
        ]);
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Booking $booking, string $status): JsonResponse
    {
        if (!in_array($status, ['pending', 'confirmed', 'cancelled'])) {
            return response()->json([
                'message' => 'Invalid status',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $booking->update(['status' => $status]);

        return response()->json([
            'message' => 'Booking status updated successfully',
            'data' => $booking->load('trip')
        ]);
    }
}
