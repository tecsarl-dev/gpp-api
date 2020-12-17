<?php

namespace App\Gpp\Depots\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepotRequest extends FormRequest
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
            "designation" => "required",
            "code_depot" => "required|unique:depots,code_depot,".$this->id,
            "country" => "required",
            "city" => "required",
            "address" => "required",
            "phone" => "required",
            "email" => "required",
            "unity" => "required",
            "capacity" => "required",
            "active" => "required",
            "gpp" => "required"
        ];
    }
}
