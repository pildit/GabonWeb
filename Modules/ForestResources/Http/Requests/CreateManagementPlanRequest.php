<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateManagementPlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ManagementUnit' => 'required|exists:Modules\ForestResources\Entities\ManagementUnit,Id',
            'Species' => 'required|integer',
            'GrossVolumeUFG' => 'required|numeric',
            'GrossVolumeYear' => 'required|numeric',
            'YieldVolumeYear' => 'required|numeric',
            'CommercialVolumeYear' => 'required|numeric',
            'Approved' => 'bool'
        ];
    }

}
