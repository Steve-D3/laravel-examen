<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a listing of all trips.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $trips = Trip::select([
            'id',
            'title',
            'region',
            'start_date',
            'duration_days',
            'price_per_person',
        ])
        ->orderBy('start_date')
        ->get();

        return response()->json($trips);
    }

    // The following methods are not needed for our API but are kept for RESTful consistency
    public function store(Request $request) {}
    public function show(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
