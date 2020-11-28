<?php

namespace App\Gpp\Rates\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRateRequest extends FormRequest
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
