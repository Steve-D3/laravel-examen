<?php

namespace Database\Factories;

use App\Models\Trip;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'confirmed', 'cancelled'];
        
        return [
            'trip_id' => function () {
                return Trip::inRandomOrder()->first()->id ?? \Database\Factories\TripFactory::new()->create()->id;
            },
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'number_of_people' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement($statuses),
        ];
    }

    /**
     * Indicate that the booking is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the booking is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate that the booking is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
