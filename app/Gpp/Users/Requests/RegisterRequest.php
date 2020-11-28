<?php

namespace App\Gpp\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'password_c' => 'required_with:password|same:password|min:7',
        ];
    }
}
