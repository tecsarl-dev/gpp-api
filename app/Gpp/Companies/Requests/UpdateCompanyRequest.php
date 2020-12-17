<?php

namespace App\Gpp\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'type' =>"required",
            'country' =>"required",
            'address' =>"required",
            'zip_code' =>"required",
            'phone1' =>"required",
            'email_company' =>"required",
            'ifu' =>"required",
            'rccm' =>"required",
            'social_reason' =>"required",
            'social_capital' =>"required",
            'status' =>"required",
            'approval_number' =>"required",
            'bank' =>"required",
            'bank_code' =>"required",
            'bank_reference' =>"required",
            'account_number' =>"required",
            'counter_code' =>"required",
            'rib' =>"required",
            'swift' =>"required",
            'iban' =>"required",
            'bank_address' =>"required",
            'fiscal_regime' =>"required",
        ];
    }
}
