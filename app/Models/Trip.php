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

    protected $hidden = [
        'created_at',
        'updated_at',
        'total_revenue'
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
    protected $appends = ['total_revenue', 'end_date'];

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
     * Get the total revenue from confirmed bookings for this trip.
     *
     * @return float
     */
    public function getTotalRevenueAttribute()
    {
        $totalPeople = $this->bookings()
            ->where('status', 'confirmed')
            ->sum('number_of_people');
            
        return $this->price_per_person * $totalPeople;
    }

    /**
     * Get the calculated end date based on start date and duration.
     *
     * @return string|null
     */
    public function getEndDateAttribute()
    {
        if (!$this->start_date || !$this->duration_days) {
            return null;
        }
        return $this->start_date->copy()->addDays($this->duration_days - 1);
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
