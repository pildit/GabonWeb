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
            "Permit" => "exists:Modules\Transport\Entities\Permit,Id",
            "LogId" =>"required|string",
            "Species" => "required|integer", // Todo - add Species validation;
            "MinDiameter" => "required|number",
            "MaxDiameter" => "required|number",
            "AverageDiameter" => "required|",
            "Length" => "required|number",
            "Volume" => "required|number",
            "MobileId" => "required|unique:Modules\Transport\Entities\Item,MobileId"
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
