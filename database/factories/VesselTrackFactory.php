<?php

namespace Database\Factories;

use App\Models\VesselTrack;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VesselTrack>
 */
class VesselTrackFactory extends Factory
{
    protected $model = VesselTrack::class;
    public function definition(): array
    {
        return [
            'timestamp' => $this->faker->dateTimeBetween('-2 days', '-1 day')->format('Y-m-d H:i:s'),
            'mmsi' => rand(1000000000, 3000000000),
            'lat' => $this->faker->latitude,
            'lon' => $this->faker->longitude,
            'status' => rand(0,2),
            'stationId' => rand(0, 200),
            'speed' => rand(0, 200),
            'course' => rand(0, 200),
            'heading' => rand(0, 200),
            'rot' => rand(0, 360)
        ];
    }
}
