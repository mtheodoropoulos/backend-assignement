<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShipPosition extends Model
{
    use HasFactory;

    protected $table = 'ship_positions';

    protected $fillable = [
        'mmsi',
        'status',
        'stationId',
        'speed',
        'lon',
        'lat',
        'course',
        'heading',
        'rot',
        'timestamp',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function is_field_empty($field){
        if((empty($field)) && (!isset($field)))
        {
            return true;
        }
        return false;
    }
    public function scopeFiltered($query)
    {
        if (!$this->is_field_empty(request()->get('mmsi')))
        {
            $mmsi_array=request()->get('mmsi');
            $query->whereIn('mmsi', $mmsi_array);
        }
        
        if (!$this->is_field_empty(request()->get('course')))
        {
            $query->where('course',request()->get('course') );
        } 
        
        if (!$this->is_field_empty(request()->get('lat')))
        {
            $query->where('lat',request()->get('lat') );
        }
        
        if (!$this->is_field_empty(request()->get('lon')))
        {
            $query->where('lon',request()->get('lon') );
        }
        if (!$this->is_field_empty(request()->get('timeStart')) && !is_null(request()->get('timeEnd')) )
        {
            $timeStart = Carbon::createFromFormat('Y-m-d H:i:s', request()->get('timeStart'));
            $timeEnd = Carbon::createFromFormat('Y-m-d H:i:s', request()->get('timeEnd'));

            $query->where('timestamp', '>=', $timeStart)->where('timestamp', '<=', $timeEnd);
        }

        return $query;
    }

}
