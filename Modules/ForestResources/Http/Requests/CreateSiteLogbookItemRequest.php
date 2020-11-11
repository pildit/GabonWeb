<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSiteLogbookItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'SiteLogbook' => 'required',
            'HewingId' => 'required|integer',
            'Date' => 'required|date',
            'MaxDiameter' => 'required|numeric',
            'MinDiameter' => 'required|numeric',
            'AverageDiameter' => 'required|numeric',
            'Length' => 'required|numeric',
            'Volume' => 'required|numeric',
            'ObserveAt' => 'required|date',
            'Approved' => 'bool',
        ];
    }

}
