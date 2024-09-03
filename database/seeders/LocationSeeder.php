<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use Carbon\Carbon; 

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $locations = [
            [
                'loc_name' => '亞洲帝國',
                'code' => 'A001',
                'latitude' => 22.7539464,
                'longitude' => 120.4447548,
                'start_date' => Carbon::now(),
                'end_date' => null,
                'is_delete' => false,
            ],
            [
                'loc_name' => '亞洲帝國2',
                'code' => 'A002',
                'latitude' => 22.7539464,
                'longitude' => 120.4447548,
                'start_date' => null,
                'end_date' => null,
                'is_delete' => false,
            ],
            [
                'loc_name' => '亞洲帝國3',
                'code' => 'A003',
                'latitude' => 22.7539464,
                'longitude' => 120.4447548,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addYears(2),
                'is_delete' => false,
            ],
            // Add more locations as needed
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? $this->start_date->format('Y-m-d') : 'N/A';
    }
}
