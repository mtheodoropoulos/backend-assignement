<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VesselTrackSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'mmsi' => 'sometimes',
            'mmsi.*' => 'required_with:mmsi|integer',
            'coordinates' => 'sometimes',
            'coordinates.min_lat' => 'required_with:coordinates.max_lat,coordinates.min_lon,coordinates.max_lon',
            'coordinates.max_lat' => 'required_with:coordinates.min_lat,coordinates.min_lon,coordinates.max_lon',
            'coordinates.min_lon' => 'required_with:coordinates.min_lat,coordinates.max_lat,coordinates.max_lon',
            'coordinates.max_lon' => 'required_with:coordinates.min_lat,coordinates.max_lat,coordinates.min_lon',
            'interval' => 'sometimes',
            'interval.start_time' => 'integer|date_format:U',
            'interval.end_time' => 'integer|date_format:U',
        ];
    }
}
