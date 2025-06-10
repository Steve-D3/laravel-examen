<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TripController extends Controller
{
    /**
     * Display a listing of all trips.
     */
    public function index(): JsonResponse
    {
        $trips = Trip::all();

        return response()->json($trips);
    }

    /**
     * Store a newly created trip in storage.
     */
    public function store(TripRequest $request): JsonResponse
    {
        $trip = Trip::create($request->validated());

        return response()->json([
            'message' => 'Trip created successfully',
            'data' => $trip
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified trip.
     */
    public function show(Trip $trip): JsonResponse
    {
        return response()->json([
            'data' => $trip->load('bookings')
        ]);
    }

    /**
     * Update the specified trip in storage.
     */
    public function update(TripRequest $request, Trip $trip): JsonResponse
    {
        $trip->update($request->validated());

        return response()->json([
            'message' => 'Trip updated successfully',
            'data' => $trip->refresh()
        ]);
    }

    /**
     * Remove the specified trip from storage.
     */
    public function destroy(Trip $trip): JsonResponse
    {
        if ($trip->bookings()->exists()) {
            return response()->json([
                'message' => 'Cannot delete trip with existing bookings',
            ], Response::HTTP_CONFLICT);
        }

        $trip->delete();

        return response()->json([
            'message' => 'Trip deleted successfully'
        ]);
    }


}
