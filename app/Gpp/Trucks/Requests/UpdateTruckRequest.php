<?php

namespace App\Gpp\Trucks\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTruckRequest extends FormRequest
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
           "truck_number" => "required|unique:trucks,truck_number,".$this->truck_number,
           "property" => "required",
           "type" => "required",
           "gauging_certificate_number" => "required",
           "assurance_validity" => "required",
           "taxation" => "required",
           "taxation_date_validity" => "required",
           "active" => "required",
           "transporter" => "required",
        ];
    }
}
