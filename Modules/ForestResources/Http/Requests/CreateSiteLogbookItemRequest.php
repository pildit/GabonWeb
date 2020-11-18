<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSiteLogbookItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'SiteLogbook' => 'required',
            'Species' => 'required|exists:Modules\ForestResources\Entities\Species,Id',
            'HewingId' => 'required|string',
            'Date' => 'required|date_format:Y-m-d H:i:s',
            'MaxDiameter' => 'required|numeric',
            'MinDiameter' => 'required|numeric',
            'AverageDiameter' => 'required|numeric',
            'Length' => 'required|numeric',
            'Volume' => 'required|numeric',
            'ObserveAt' => 'required|date_format:Y-m-d H:i:s',
            'Approved' => 'bool',
            'MobileId' => 'string|unique:Modules\ForestResources\Entities\SiteLogbookItem,MobileId'
        ];
    }

}
