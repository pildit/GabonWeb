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
            'SiteLogbook' => 'exists:Modules\ForestResources\Entities\SiteLogbook,Id',
            'HewingId' => 'string',
            'Date' => 'date',
            'MaxDiameter' => 'numeric',
            'MinDiameter' => 'numeric',
            'AverageDiameter' => 'numeric',
            'Length' => 'numeric',
            'Volume' => 'numeric',
            'ObserveAt' => 'date',
            'Approved' => 'bool',
            'MobileId' => 'string'
        ];
    }

}
