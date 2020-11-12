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
            'TreeId' => 'string',
            'HewingId' => 'string',
            'Species' => 'integer',
            'MaxDiameter' => 'numeric',
            'MinDiameter' => 'numeric',
            'Length' => 'numeric',
            'Volume' => 'numeric',
            'GpsAccu' => 'numeric',
            'Note' => 'string',
            'ObserveAt' => 'date',
            'Approved' => 'bool',
        ];
    }

}
