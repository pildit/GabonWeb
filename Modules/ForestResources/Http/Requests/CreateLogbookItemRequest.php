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
            'AnnualAllowableCutInventory' => 'required|exists:Modules\ForestResources\Entities\AnnualAllowableCutInventory,Id',
            'HewingId' => 'required|integer',
            'Species' => 'required|integer',
            'MaxDiameter' => 'required|numeric',
            'MinDiameter' => 'required|numeric',
            'Length' => 'required|numeric',
            'Volume' => 'required|numeric',
            'Lat' => 'required',
            'Lon' => 'required',
            'GpsAccu' => 'required|numeric',
            'Note' => 'required|string',
            'ObserveAt' => 'required|date',
            'Approved' => 'bool',
        ];
    }

}
