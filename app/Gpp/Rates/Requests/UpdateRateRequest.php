<?php

namespace App\Gpp\Rates\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRateRequest extends FormRequest
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
            "code_rate" => "required|unique:rates,code_rate,".$this->id,
            "city_start" => "required",
            "city_end" => "required",
            "unit_price" => "required",
            "unity" => "required",
            "active" => "required",
            "product_id" => "required",
            "gpp" => "required",
        ];
    }
}
