<?php

namespace App\Console\Commands;

use App\Models\Station;
use App\Models\Vessel;
use App\Models\VesselTrack;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportVesselTracks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-vessel-tracks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Vessels';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = json_decode(file_get_contents(storage_path() . '/tracks/ship_positions.json'), true);

        $batches = array_chunk($data, 500);

        foreach ($batches as $batch) {
            DB::beginTransaction();

            try {
                foreach ($batch as $track) {

                    Vessel::firstOrCreate(
                        ['mmsi' => $track['mmsi']],
                        ['mmsi' => $track['mmsi']]
                    );

                    Station::firstOrCreate(
                        ['id' => $track['stationId']],
                        ['name' => 'name' . $track['stationId']]
                    );

                    VesselTrack::create([
                        'mmsi' => $track['mmsi'],
                        'status' => $track['status'],
                        'stationId' => $track['stationId'],
                        'speed' => $track['speed'],
                        'lon' => $track['lon'],
                        'lat' => $track['lat'],
                        'course' => $track['course'],
                        'heading' => $track['heading'],
                        'rot' => $track['rot'],
                        'timestamp' => Carbon::createFromTimestamp($track['timestamp'])->format('Y-m-d H:i:s'),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }

                DB::commit();
            } catch (Exception $exception) {

                Log::info('Failed to insert ' . $exception->getMessage());

                DB::rollBack();
            }
        }
    }
}
