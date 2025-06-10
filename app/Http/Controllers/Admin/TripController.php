<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TripController extends Controller
{
    /**
     * Display a listing of the trips with booking statistics.
     */
    public function __invoke(Request $request): View
    {
        // Eager load bookings for better performance
        $trips = Trip::withCount([
            'bookings as pending_bookings_count' => function ($query) {
                $query->where('status', 'pending');
            },
            'bookings as confirmed_bookings_count' => function ($query) {
                $query->where('status', 'confirmed');
            },
            'bookings as cancelled_bookings_count' => function ($query) {
                $query->where('status', 'cancelled');
            },
        ])
        ->withSum([
            'bookings as total_participants' => function ($query) {
                $query->where('status', 'confirmed');
            },
        ], 'number_of_people')
        ->orderBy('start_date')
        ->get()
        ->map(function ($trip) {
            // Calculate total revenue
            $trip->total_revenue = $trip->price_per_person * ($trip->total_participants ?? 0);
            return $trip;
        });

        return view('admin.trips.index', compact('trips'));
    }
}
