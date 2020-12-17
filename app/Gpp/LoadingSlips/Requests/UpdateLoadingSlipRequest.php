<?php

namespace App\Gpp\LoadingSlips\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoadingSlipRequest extends FormRequest
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
            "code_loading" => "required|unique:loading_slips,code_loading,".$this->id,
            "issue_date" => "required",
            "fiscale_regime" => "required",
            "loading_type" => "required",
            "planned_loading_date" => "required",
            "driver" => "required",
            "truck_id" => "required",
            "depot_id" => "required",
        ];
    }
}
