<?php

namespace App\Gpp\Stations\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStationRequest extends FormRequest
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
    public function rules()
    {
        return [
            "code_station" =>  [
                'required',
                Rule::unique('stations')->ignore($this->id),
            ],
            'country' => 'required',
            'city' => 'required',
            'responsible_id' => 'required',
            'responsible_name' => 'required',
            'responsible_tel' => 'required',
            'responsible_email' => 'required',
            'capacity_gaz' => 'required',
            'capacity_fuel' => 'required',
            'capacity_gpl' => 'required',
            'capacity_id' => 'required',
        ];
    }
}
