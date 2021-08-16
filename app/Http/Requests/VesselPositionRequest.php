<?php

namespace App\Http\Requests;

use App\Rules\isLatValid;
use App\Rules\isLonValid;
use App\Http\Requests\BaseApiRequest;

class VesselPositionRequest extends BaseApiRequest
{
     /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
   
    public function validationData()
    {
        $inputs =request()->get('requestArray');
        // Sanitize $inputs as your likes.

        $this->replace($inputs); // To persist.
        
        return $this->all();
    }

    public function rules()
    {
        return [
            'mmsi'        => ['numeric_array'],
            'mmsi.*'        => ['exists:ship_positions,mmsi'],
            'lat'         => [ new isLatValid],
            'lon'         =>  [ new isLonValid],
            'timeStart'         =>  [ 'date_format:Y-m-d H:i:s'],
            'timeEnd'         =>  [ 'date_format:Y-m-d H:i:s']
        ];
    }
}

