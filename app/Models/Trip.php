<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'region',
        'start_date',
        'duration_days',
        'price_per_person',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'price_per_person' => 'decimal:2',
        'duration_days' => 'integer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['total_revenue'];

    /**
     * Get the bookings for the trip.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the bookings count by status.
     */
    public function getBookingsCountByStatus(): array
    {
        return $this->bookings()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    /**
     * Get the total revenue from confirmed bookings.
     */
    public function getTotalRevenueAttribute(): float
    {
        $confirmedBookings = $this->bookings()
            ->where('status', 'confirmed')
            ->sum('number_of_people');

        return $this->price_per_person * $confirmedBookings;
    }

    /**
     * Scope a query to only include upcoming trips.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())
                    ->orderBy('start_date');
    }
}
