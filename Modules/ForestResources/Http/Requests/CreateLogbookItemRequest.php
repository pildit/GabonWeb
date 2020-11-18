<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLogbookItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Logbook' => 'required',
            'TreeId' => 'required|string',
            'HewingId' => 'required|string',
            'Species' => 'required|integer',
            'MaxDiameter' => 'required|numeric',
            'MinDiameter' => 'required|numeric',
            'Length' => 'required|numeric',
            'Volume' => 'required|numeric',
            'Lat' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'Lon' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'GpsAccu' => 'required|numeric',
            'Note' => '',
            'ObserveAt' => 'required|date_format:Y-m-d H:i:s',
            'Approved' => 'bool',
            'MobileId' => 'string|unique:Modules\ForestResources\Entities\LogbookItem,MobileId',
        ];
    }

}
