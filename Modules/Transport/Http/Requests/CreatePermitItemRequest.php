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
            "LogId" =>"required|string",
            "Species" => "required|exists:Modules\ForestResources\Entities\Species,Id",
            "MinDiameter" => "required|numeric",
            "MaxDiameter" => "required|numeric",
            "AverageDiameter" => "required|",
            "Length" => "required|numeric",
            "Volume" => "required|numeric",
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
