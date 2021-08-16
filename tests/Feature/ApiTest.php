<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRouteVesselPositions()
    {
        $response = $this->json('GET', 'api/vessel/positions?mmsi[]=247039300&mmsi[]=311040700', ['Accept' => 'application/json']);

        $response ->assertStatus(200)
        ->assertJson([
            "success"=>  true,
            "message"=> "Ship Positions retrieved successfully.",
            "reponse" => [
                "total_rows"=> 1836,
            ]
        ]);
    }
}
