<?php

namespace App\Gpp\Deliveries\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeliveryRequest extends FormRequest
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
            "delivery_date" => "required",
            "customer_type" => "required",
            "destination" => "required",
            "city" => "required",
            "receptionist" => "required",
            "waybill_number" => "required",
            "reference" => "required",
            "approuved" => "required",
            "loading_slip_id" => "required",  
            "products" => "required",  
        ];
    }
}
