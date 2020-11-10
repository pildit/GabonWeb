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
            "Permit" => "required",
            "TreeId" =>"required:string",
            "Species" => "required", // Todo - add Species validation;
            "MinDiameter" => "required",
            "MaxDiameter" => "required",
            "AverageDiameter" => "required",
            "Length" => "required",
            "Volume" => "required",
            "MobileId" => "required:string"
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
