<?php

namespace App\Gpp\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            "code_product" => "required|unique:products,code_product,".$this->id,
            "name" => "required",
            "unity" => "required",
            "gpp" => "required",
            "active" => "required",
            "spefication" => "required",
        ];
    }
}
