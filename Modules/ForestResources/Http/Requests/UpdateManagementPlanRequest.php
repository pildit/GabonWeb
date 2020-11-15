<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\ForestResources\Entities\ManagementPlan;

class UpdateManagementPlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'ManagementUnit' => 'exists:Modules\ForestResources\Entities\ManagementUnit,Id',
            'Species' => 'integer',
            'GrossVolumeUFG' => 'numeric',
            'GrossVolumeYear' => 'numeric',
            'YieldVolumeYear' => 'numeric',
            'CommercialVolumeYear' => 'numeric',
            'Approved' => 'bool'
        ];
    }

}
