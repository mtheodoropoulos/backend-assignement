<?php

use App\Models\VesselTrack;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VesselTrackControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function filter_by_all_parameters()
    {
        $this->withoutMiddleware();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        VesselTrack::factory()->count(10)->create();

        VesselTrack::factory()->create(
            ['mmsi' => 247039301, 'timestamp' => Carbon::createFromTimestamp(1372700280)->format('Y-m-d H:i:s'), 'lat' => 16.88888, 'lon' => 41.99998]
        );

        VesselTrack::factory()->count(6)->create(
            ['mmsi' => 247039300, 'timestamp' => Carbon::createFromTimestamp(1372700280)->format('Y-m-d H:i:s'), 'lat' => 16.88888, 'lon' => 41.99998]
        );
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $response = $this->get('/api/vessel-tracks?mmsi[]=247039300&mmsi[]=247039301&coordinates[min_lat]=16.88887&coordinates[max_lat]=16.88889&coordinates[min_lon]=41.99997&coordinates[max_lon]=41.99999&interval[start_time]=1372700279&interval[end_time]=1372700281');

        $response->assertStatus(200);
        $response->assertJsonCount(7);
    }

    /** @test */
    public function filter_single_mmsi()
    {
        $this->withoutMiddleware();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        VesselTrack::factory()->count(10)->create();

        VesselTrack::factory()->count(6)->create(
            ['mmsi' => 247039300, 'timestamp' => Carbon::createFromTimestamp(1372700280)->format('Y-m-d H:i:s'), 'lat' => 16.88888, 'lon' => 41.99998]
        );
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $response = $this->get('/api/vessel-tracks?mmsi=247039300&coordinates[min_lat]=16.88887&coordinates[max_lat]=16.88889&coordinates[min_lon]=41.99997&coordinates[max_lon]=41.99999&interval[start_time]=1372700279&interval[end_time]=1372700281');

        $response->assertStatus(200);
        $response->assertJsonCount(6);
    }

    /** @test */
    public function filter_with_single_lat()
    {
        $this->withoutMiddleware();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        VesselTrack::factory()->count(10)->create();

        VesselTrack::factory()->count(6)->create(['lat' => 16.88888, 'lon' => 41.99998]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $response = $this->get('/api/vessel-tracks?coordinates[max_lat]=16.88889');

        $response->assertStatus(302);
    }

    /** @test */
    public function filter_by_end_time()
    {
        $this->withoutMiddleware();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        VesselTrack::factory()->count(6)->create(
            ['timestamp' => Carbon::createFromTimestamp(1222222222)->format('Y-m-d H:i:s')]
        );
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $response = $this->get('/api/vessel-tracks?interval[end_time]=1222222222');

        $response->assertStatus(200);
        $response->assertJsonCount(6);
    }

    /** @test */
    public function filter_by_start_time()
    {
        $this->withoutMiddleware();

        $now = Carbon::now()->getTimestamp();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        VesselTrack::factory()->count(6)->create(
            ['timestamp' => Carbon::now()->format('Y-m-d H:i:s')]
        );
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $response = $this->get('/api/vessel-tracks?interval[start_time]=' . $now);

        $response->assertStatus(200);
        $response->assertJsonCount(6);
    }

    /** @test */
    public function filter_by_both_start_and_end_times()
    {
        $this->withoutMiddleware();

        $now = Carbon::now();
        $nowMinusOneSecond = $now->getTimestamp() - 1;
        $nowPlusOneSecond = $now->getTimestamp() + 1;

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        VesselTrack::factory()->count(6)->create(
            ['timestamp' => $now->format('Y-m-d H:i:s')]
        );
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $response = $this->get('/api/vessel-tracks?interval[start_time]=' . $nowMinusOneSecond . '&interval[end_time]=' . $nowPlusOneSecond);

        $response->assertStatus(200);
        $response->assertJsonCount(6);
    }

    /** @test */
    public function filter_by_random_param()
    {
        $this->withoutMiddleware();

        $response = $this->get('/api/vessel-tracks?interval[asdf]=1372700279');

        $response->assertStatus(200);
    }
}
