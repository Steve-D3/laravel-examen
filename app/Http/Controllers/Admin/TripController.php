<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Models\Trip;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TripController extends Controller
{
    /**
     * Display a listing of the trips with booking statistics.
     */
    public function index(): View
    {
        $trips = $this->getTripsWithStats();
        return view('admin.trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new trip.
     */
    public function create(): View
    {
        return view('admin.trips.create');
    }

    /**
     * Store a newly created trip in storage.
     */
    public function store(TripRequest $request): RedirectResponse
    {
        $trip = Trip::create($request->validated());
        
        return redirect()
            ->route('admin.trips.index')
            ->with('success', 'Trip created successfully!');
    }

    /**
     * Display the specified trip.
     */
    public function show(Trip $trip): View
    {
        // Paginate the bookings relationship
        $bookings = $trip->bookings()
            ->latest()
            ->paginate(10);
            
        return view('admin.trips.show', [
            'trip' => $trip,
            'bookings' => $bookings
        ]);
    }

    /**
     * Show the form for editing the specified trip.
     */
    public function edit(Trip $trip): View
    {
        return view('admin.trips.edit', compact('trip'));
    }

    /**
     * Update the specified trip in storage.
     */
    public function update(TripRequest $request, Trip $trip): RedirectResponse
    {
        $trip->update($request->validated());
        
        return redirect()
            ->route('admin.trips.index')
            ->with('success', 'Trip updated successfully!');
    }

    /**
     * Remove the specified trip from storage.
     */
    public function destroy(Trip $trip): RedirectResponse
    {
        if ($trip->bookings()->exists()) {
            return back()->with('error', 'Cannot delete trip with existing bookings.');
        }
        
        $trip->delete();
        
        return redirect()
            ->route('admin.trips.index')
            ->with('success', 'Trip deleted successfully!');
    }
    
    /**
     * Get trips with booking statistics.
     */
    protected function getTripsWithStats()
    {
        return Trip::withCount([
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
            ->paginate(10)
            ->through(function ($trip) {
                $trip->total_revenue = $trip->price_per_person * ($trip->total_participants ?? 0);
                return $trip;
            });
    }
    
    /**
     * Handle the default route.
     */
    public function __invoke()
    {
        return $this->index();
    }
}
