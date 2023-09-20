<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vessel extends Model
{
    use HasFactory;

    protected $fillable = ['mmsi'];

    public function tracks(): HasMany
    {
        return $this->hasMany(VesselTrack::class, 'mmsi', 'mmsi');
    }
}
