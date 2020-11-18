<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLogbookItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Logbook' => '',
            'TreeId' => 'string',
            'HewingId' => 'string',
            'Species' => 'integer',
            'MaxDiameter' => 'numeric',
            'MinDiameter' => 'numeric',
            'Length' => 'numeric',
            'Volume' => 'numeric',
            'Lat' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'Lon' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'GpsAccu' => 'numeric',
            'Note' => '',
            'ObserveAt' => 'date_format:Y-m-d H:i:s',
            'Approved' => 'bool',
            'MobileId' => 'string',
        ];
    }

}
