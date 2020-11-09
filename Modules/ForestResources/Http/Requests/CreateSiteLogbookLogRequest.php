<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSiteLogbookLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'SiteLogbookItem' => 'required|exists:Modules\ForestResources\Entities\SiteLogbookItem,Id',
            'HewingId' => 'required|integer',
            'Species' => 'required|integer',
            'MaxDiameter' => 'required|numeric',
            'MinDiameter' => 'required|numeric',
            'AverageDiameter' => 'required|numeric',
            'Length' => 'required|numeric',
            'Volume' => 'required|numeric',
            'Note' => 'required|string',
            'EvacuationDate' => 'required|date',
            'Lat' => 'required|numeric',
            'Lon' => 'required|numeric',
            'GPSAccu' => 'required|numeric',
            'ObserveAt' => 'required|date',
            'Approved' => 'bool',
        ];
    }

}
