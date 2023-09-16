<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasFilters
{

    public function filter($filters)
    {
        if ($filters['mmsi']) {
            $this->mmsi($filters['mmsi']);
        }

        if (isset($filters['coordinates'])) {
            $this->geolocation($filters['coordinates']);
        }

        if (isset($filters['interval'])) {
            $this->interval($filters['interval']);
        }

        return $this;
    }

    private function mmsi(mixed $mmsi)
    {
        if (is_array($mmsi)) {
            return $this->whereIn('mmsi', $mmsi);
        }

        return $this->where('mmsi', $mmsi);
    }

    private function geolocation(array $coordinates)
    {
        return $this->whereBetween('lat', [$coordinates['min_lat'], $coordinates['max_lat']])
            ->whereBetween('lon', [$coordinates['min_lon'], $coordinates['max_lon']]);
    }

    private function interval(array $time)
    {
        if (isset($time['start_time']) && isset($time['end_time'])) {
            return $this->whereBetween('timestamp', [
                Carbon::parse($time['start_time'])->format('Y-m-d H:i:s'),
                Carbon::parse($time['end_time'])->format('Y-m-d H:i:s')
            ]);
        }

        if (isset($time['start_time'])) {
            return $this->whereDate('timestamp', '>=', Carbon::parse($time['start_time'])->format('Y-m-d H:i:s'));
        }

        if (isset($time['end_time'])) {
            return $this->whereDate('timestamp', '<=', Carbon::parse($time['end_time'])->format('Y-m-d H:i:s'));
        }

        return $this;
    }

}
