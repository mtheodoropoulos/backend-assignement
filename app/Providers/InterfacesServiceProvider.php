<?php

namespace App\Providers;

use App\Services\LoggerService;
use App\Services\ParserService;
use App\Interfaces\LoggerInterface;
use App\Services\VesselTrackingService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\LoggerServiceInterface;
use App\Interfaces\ParserServiceInterface;
use App\Interfaces\VesselTrackingInterface;
use App\Strategies\LogStrategy\Implementations\FileLogger;

class InterfacesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VesselTrackingInterface::class, VesselTrackingService::class);
        $this->app->bind(ParserServiceInterface::class, ParserService::class);
        $this->app->bind(LoggerInterface::class, FileLogger::class);
        $this->app->bind(LoggerServiceInterface::class, LoggerService::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
