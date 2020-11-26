<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnualOperationPlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'AnnualAllowableCut' => 'exists:Modules\ForestResources\Entities\AnnualAllowableCut,Id',
            'Species' => 'integer',
            'ExploitableVolume' => 'numeric',
            'NonExploitableVolume' => 'numeric',
            'VolumePerHectare' => 'numeric',
            'AverageVolume' => 'numeric',
            'TotalVolume' => 'numeric',
            'Approved' =>'bool'
        ];
    }

}
