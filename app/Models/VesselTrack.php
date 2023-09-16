<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasFilters;

class VesselTrack extends Model
{
    use HasFilters;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'mmsi', 'status', 'stationId', 'speed', 'lon', 'lat', 'course', 'heading', 'rot', 'timestamp', 'created_at',
        'updated_at', 'deleted_at'
    ];

    public function vessel(): BelongsTo
    {
        return $this->belongsTo(Vessel::class, 'mmsi', 'mmsi');
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'stationId', 'id');
    }
}
