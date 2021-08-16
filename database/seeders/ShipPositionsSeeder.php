<?php

namespace Database\Seeders;

use App\Models\ShipPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ShipPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ShipPositions_json= Storage::disk('ShipPositions')->get('ship_positions.json'); 
        $ShipPositions_objs=json_decode($ShipPositions_json);
        DB::table('ship_positions')->delete();
        foreach ($ShipPositions_objs as $ShipPositions_obj)  {
            ShipPosition::create([
                "mmsi" => $ShipPositions_obj->mmsi,
                "status" => $ShipPositions_obj->status,
                "stationId" => $ShipPositions_obj->stationId,
                "speed" => $ShipPositions_obj->speed,
                "lon" => $ShipPositions_obj->lon,
                "lat" => $ShipPositions_obj->lat,
                "course" => $ShipPositions_obj->course,
                "heading" => $ShipPositions_obj->heading,
                "rot" => $ShipPositions_obj->rot,
                "timestamp" => $ShipPositions_obj->timestamp,
            ]);
		}
	}
    
}
