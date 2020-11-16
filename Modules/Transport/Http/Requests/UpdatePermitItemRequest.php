<?php

namespace Modules\Transport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermitItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "Permit" => "",
            "LogId" =>"string",
            "Species" => "integer", // Todo - add Species validation;
            "MinDiameter" => "numeric",
            "MaxDiameter" => "numeric",
            "AverageDiameter" => "numeric",
            "Length" => "numeric",
            "Volume" => "numeric",
            "MobileId" => "string"
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
