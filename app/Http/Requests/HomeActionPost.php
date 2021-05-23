<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeActionPost extends FormRequest
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
            "sender_name" => ["required", "string"],
            "recipient"   => ["required", "string"],
            "endpoint"    => ["required", "string"],
            "product"     => ["required", "string"],
            "price"       => ["required", "regex:/^\d*(\.\d{2})?$/"],
            "phone"       => ["required", "integer"],
        ];

    }
}
