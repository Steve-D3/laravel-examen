<?php

namespace Database\Seeders;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraint violations
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing trips and reset auto-increment
        Trip::truncate();
        \DB::statement('ALTER TABLE trips AUTO_INCREMENT = 1;');
        \DB::statement('ALTER TABLE bookings AUTO_INCREMENT = 1;');
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Fixed trips to ensure we have at least one per region
        $fixedTrips = [
            [
                'title' => 'Off-Grid Camping in Jasper',
                'region' => 'west',
                'start_date' => Carbon::now()->addDays(30),
                'duration_days' => 6,
                'price_per_person' => 1234.56,
            ],
            [
                'title' => 'Surf & Storm in Tofino',
                'region' => 'west',
                'start_date' => Carbon::now()->addDays(45),
                'duration_days' => 2,
                'price_per_person' => 123.56,
            ],
            [
                'title' => 'Paddle & Camp in Algonquin',
                'region' => 'east',
                'start_date' => Carbon::now()->addDays(60),
                'duration_days' => 5,
                'price_per_person' => 1234.56,
            ],
            [
                'title' => 'Underground Montréal',
                'region' => 'east',
                'start_date' => Carbon::now()->addDays(15),
                'duration_days' => 2,
                'price_per_person' => 123.56,
            ],
            [
                'title' => 'Northern Light Hunting in Yellowknife',
                'region' => 'north',
                'start_date' => Carbon::now()->addDays(90),
                'duration_days' => 4,
                'price_per_person' => 2345.56,
            ],
            [
                'title' => 'Whales & Waves in Tadoussac',
                'region' => 'east',
                'start_date' => Carbon::now()->addDays(10),
                'duration_days' => 1,
                'price_per_person' => 99.99,
            ]
        ];

        // Create the fixed trips
        foreach ($fixedTrips as $tripData) {
            Trip::create($tripData);
        }

        // If you want to add more random trips, you can use the factory
        // Trip::factory()->count(4)->create();
    }
}
