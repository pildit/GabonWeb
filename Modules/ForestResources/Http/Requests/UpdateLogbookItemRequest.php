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
            'Logbook' => 'exists:Modules\ForestResources\Entities\Logbook,Id',
            'AnnualAllowableCutInventory' => 'exists:Modules\ForestResources\Entities\AnnualAllowableCutInventory,Id',
            'HewingId' => 'integer',
            'Species' => 'integer',
            'MaxDiameter' => 'numeric',
            'MinDiameter' => 'numeric',
            'Length' => 'numeric',
            'Volume' => 'numeric',
            'GPSAccuracy' => 'numeric',
            'Note' => 'string',
            'ObserveAt' => 'date',
            'Approved' => 'bool',
        ];
    }

}
