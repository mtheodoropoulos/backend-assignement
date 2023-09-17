<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasFilters
{
    public function scopeMmsi($query, mixed $mmsi)
    {
        if (is_array($mmsi)) {
            return $query->whereIn('mmsi', $mmsi);
        }

        return $query->where('mmsi', $mmsi);
    }

    public function scopeGeolocation($query, array $coordinates)
    {
        return $query->whereBetween('lat', [$coordinates['min_lat'], $coordinates['max_lat']])
            ->whereBetween('lon', [$coordinates['min_lon'], $coordinates['max_lon']]);
    }

    public function scopeInterval($query, array $time)
    {
        if (isset($time['start_time']) && isset($time['end_time'])) {
            return $query->whereBetween('timestamp', [
                Carbon::parse($time['start_time'])->format('Y-m-d H:i:s'),
                Carbon::parse($time['end_time'])->format('Y-m-d H:i:s')
            ]);
        }

        if (isset($time['start_time'])) {
            return $query->whereDate('timestamp', '>=', Carbon::parse($time['start_time'])->format('Y-m-d H:i:s'));
        }

        if (isset($time['end_time'])) {
            return $query->whereDate('timestamp', '<=', Carbon::parse($time['end_time'])->format('Y-m-d H:i:s'));
        }

        return $query;
    }
}
