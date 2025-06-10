<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index(): View
    {
        $bookings = Booking::with('trip')
            ->latest()
            ->paginate(15);
            
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(): View
    {
        $trips = \App\Models\Trip::where('start_date', '>', now())
            ->where('is_available', true)
            ->orderBy('start_date')
            ->get(['id', 'title', 'start_date']);
            
        return view('admin.bookings.create', compact('trips'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(BookingRequest $request): RedirectResponse
    {
        // Calculate total price
        $trip = \App\Models\Trip::findOrFail($request->trip_id);
        $totalPrice = $trip->price_per_person * $request->participants;
        
        // Create booking with calculated price
        $booking = new Booking($request->validated());
        $booking->total_price = $totalPrice;
        $booking->status = 'confirmed'; // Admin-created bookings are confirmed by default
        $booking->save();
        
        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking): View
    {
        $booking->load('trip');
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking): View
    {
        $trips = \App\Models\Trip::where('start_date', '>', now())
            ->orWhere('id', $booking->trip_id)
            ->orderBy('start_date')
            ->get(['id', 'title', 'start_date']);
            
        return view('admin.bookings.edit', compact('booking', 'trips'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(BookingRequest $request, Booking $booking): RedirectResponse
    {
        // Calculate total price if trip or participants changed
        if ($request->trip_id != $booking->trip_id || $request->participants != $booking->participants) {
            $trip = \App\Models\Trip::findOrFail($request->trip_id);
            $totalPrice = $trip->price_per_person * $request->participants;
            $booking->total_price = $totalPrice;
        }
        
        $booking->update($request->validated());
        
        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified booking from storage.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();
        
        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }
    
    /**
     * Update the status of the specified booking.
     */
    public function updateStatus(Booking $booking, string $status): RedirectResponse
    {
        if (!in_array($status, ['pending', 'confirmed', 'cancelled'])) {
            return back()->with('error', 'Invalid status.');
        }
        
        $booking->update(['status' => $status]);
        
        return back()->with('success', 'Booking status updated successfully!');
    }
}
