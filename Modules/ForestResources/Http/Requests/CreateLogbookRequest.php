<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLogbookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Concession' => 'required|exists:Modules\ForestResources\Entities\Concession,Id',
            'DevelopmentUnit' => 'required|exists:Modules\ForestResources\Entities\DevelopmentUnit,Id',
            'ManagementUnit' => 'required|exists:Modules\ForestResources\Entities\ManagementUnit,Id',
            'AnnualAllowableCut' => 'required|exists:Modules\ForestResources\Entities\AnnualAllowableCut,Id',
            'ObserveAt' => 'required|date_format:Y-m-d H:i:s',
            'Approved' => 'bool',
            'MobileId' => 'string|unique:Modules\ForestResources\Entities\Logbook,MobileId'
        ];
    }

}
