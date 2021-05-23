<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeActionIndex extends FormRequest
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
            "sender_name" => ["nullable", "string"],
            "recipient"   => ["nullable", "string"],
            "product"     => ["nullable", "string"],
            "price_from"  => ["nullable", "regex:/^\d*(\.\d{2})?$/", "required_with:price_to"],
            "price_to"    => ["nullable", "regex:/^\d*(\.\d{2})?$/", "required_with:price_from"],
            "date_from"   => ["date_format:Y-m-d", "required_with:date_to"],
            "date_to"     => ["date_format:Y-m-d", "required_with:date_from"],
            "endpoint"    => ["required", "string"],
            "order_by"    => ["required", "string"],
        ];
    }
}
