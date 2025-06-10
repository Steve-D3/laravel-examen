<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Booking::all();
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param StoreBookingRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        // The request is already validated at this point
        $validated = $request->validated();

        // Create the booking with status 'pending'
        $booking = Booking::create([
            'trip_id' => $validated['trip_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'number_of_people' => $validated['number_of_people'],
            'status' => 'pending',
        ]);

        // Return the created booking with 201 status
        return response()->json([
            'id' => $booking->id,
            'trip_id' => $booking->trip_id,
            'name' => $booking->name,
            'email' => $booking->email,
            'number_of_people' => $booking->number_of_people,
            'status' => $booking->status,
            'created_at' => $booking->created_at->toDateTimeString(),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return response()->noContent(501); // Not Implemented
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Response
    {
        return response()->noContent(501); // Not Implemented
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        return response()->noContent(501); // Not Implemented
    }
}
