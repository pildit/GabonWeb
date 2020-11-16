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
            "Permit" => "exists:Modules\Transport\Entities\Permit,Id",
            "LogId" =>"string",
            "Species" => "integer", // Todo - add Species validation;
            "MinDiameter" => "number",
            "MaxDiameter" => "number",
            "AverageDiameter" => "number",
            "Length" => "number",
            "Volume" => "number",
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
