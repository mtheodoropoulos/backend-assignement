<?php

namespace App\Providers;

use App\Repositories\VesselTrackRepository;
use App\Repositories\VesselTrackRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(VesselTrackRepositoryInterface::class, VesselTrackRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
