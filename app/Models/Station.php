<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];

    public function vessel(): HasMany
    {
        return $this->hasMany(VesselTrack::class, 'id', 'stationId');
    }
}
