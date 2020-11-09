<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteLogbookLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'HewingId' => 'integer',
            'Species' => 'integer',
            'MaxDiameter' => 'numeric',
            'MinDiameter' => 'numeric',
            'AverageDiameter' => 'numeric',
            'Length' => 'numeric',
            'Volume' => 'numeric',
            'Note' => 'string',
            'EvacuationDate' => 'date',
            'Lat' => 'numeric',
            'Lon' => 'numeric',
            'GPSAccu' => 'numeric',
            'ObserveAt' => 'date',
            'Approved' => 'bool',
        ];
    }

}
