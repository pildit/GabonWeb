<?php

namespace Modules\Transport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePermitItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "trunk_number" => "string",
            "lot_number" => "string",
            "species" => "string",
            "diam1" => "numeric",
            "diam2" => "numeric",
            "length" => "numeric",
            "volume" => "numeric",
            "width" => "numeric",
            "height" => "numeric",
            "mobile_id" => "string",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
