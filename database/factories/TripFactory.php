<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $regions = ['west', 'east', 'north', 'central'];
        $tripTypes = [
            'Off-Grid Camping in',
            'Surf & Storm in',
            'Paddle & Camp in',
            'Underground',
            'Skylines & Squirrels in',
            'Northern Light Hunting in',
            'Whales & Waves in',
            'Hiking Adventure in',
            'Wildlife Safari in',
            'Cultural Exploration in'
        ];

        $destinations = [
            'Jasper', 'Tofino', 'Algonquin', 'Montréal', 'Toronto', 
            'Yellowknife', 'Tadoussac', 'Banff', 'Vancouver', 'Quebec City',
            'Niagara Falls', 'Whistler', 'Victoria', 'Ottawa', 'Halifax'
        ];

        $tripType = $this->faker->randomElement($tripTypes);
        $destination = $this->faker->randomElement($destinations);
        
        // Ensure we don't have duplicate destination names
        while (str_contains($tripType, $destination)) {
            $destination = $this->faker->randomElement($destinations);
        }

        $title = "{$tripType} {$destination}";
        
        return [
            'title' => $title,
            'region' => $this->faker->randomElement($regions),
            'start_date' => $this->faker->dateTimeBetween('+1 week', '+1 year'),
            'duration_days' => $this->faker->numberBetween(1, 14),
            'price_per_person' => $this->faker->randomFloat(2, 50, 5000),
        ];
    }
}
