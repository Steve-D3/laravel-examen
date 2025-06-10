<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Trip;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

    public function run(): void
    {
        // Disable foreign key checks to avoid constraint violations
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing bookings and reset auto-increment
        Booking::truncate();
        \DB::statement('ALTER TABLE bookings AUTO_INCREMENT = 1;');
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Get all trips
        $trips = Trip::all();

        // Create bookings for each trip
        foreach ($trips as $trip) {
            // Create bookings with different statuses
            $statuses = ['pending', 'confirmed', 'cancelled'];
            
            // Create 4 bookings per trip
            for ($i = 0; $i < 4; $i++) {
                $status = $i < 3 ? $statuses[$i] : $statuses[array_rand($statuses)];
                
                Booking::create([
                    'trip_id' => $trip->id,
                    'name' => $this->faker->name(),
                    'email' => $this->faker->unique()->safeEmail(),
                    'number_of_people' => $this->faker->numberBetween(1, 10),
                    'status' => $status,
                ]);
            }
        }
    }
}
