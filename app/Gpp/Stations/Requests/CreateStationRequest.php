<?php

namespace App\Gpp\Stations\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStationRequest extends FormRequest
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
            'country' => 'required',
            'city' => 'required',
            'code_station' => 'required|unique:stations',
            'authorization_file' => 'required|file|mimes:pdf',

            'responsible_name' => 'required',
            'responsible_tel' => 'required',
            'responsible_email' => 'required',
            'capacity_gaz' => 'required',
            'capacity_fuel' => 'required',
            'capacity_gpl' => 'required',

        ];
    }
}
