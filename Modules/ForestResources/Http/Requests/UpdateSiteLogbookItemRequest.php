<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteLogbookItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'SiteLogbook' => '',
            'Species' => 'exists:Modules\ForestResources\Entities\Species,Id',
            'HewingId' => 'string',
            'Date' => 'date_format:Y-m-d H:i:s',
            'MaxDiameter' => 'numeric',
            'MinDiameter' => 'numeric',
            'AverageDiameter' => 'numeric',
            'Length' => 'numeric',
            'Volume' => 'numeric',
            'ObserveAt' => 'date_format:Y-m-d H:i:s',
            'Approved' => 'bool',
            'MobileId' => 'string'
        ];
    }

}
