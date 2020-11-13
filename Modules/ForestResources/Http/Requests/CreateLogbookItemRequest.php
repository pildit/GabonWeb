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
            'Lat' => 'required',
            'Lon' => 'required',
            'GpsAccu' => 'required|numeric',
            'Note' => 'string',
            'ObserveAt' => 'required|date',
            'Approved' => 'bool',
        ];
    }

}
