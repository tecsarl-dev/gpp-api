<?php

namespace App\Gpp\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprouvedCompanyRequest extends FormRequest
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
            "motif" => ($this->decision == 0) ? "required" : "",
            "company_id" => "required",
            "decision" => "required",
            "user_id" => "required",
            "approuved_by" => "required",
        ];
    }
}
