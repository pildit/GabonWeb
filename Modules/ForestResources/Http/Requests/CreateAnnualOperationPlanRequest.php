<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnnualOperationPlanRequest extends FormRequest
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
            'Number' => 'required|string',
            'Species' => 'required|integer',
            'ExploitableVolume' => 'required|numeric',
            'NonExploitableVolume' => 'required|numeric',
            'VolumePerHectare' => 'required|numeric',
            'AverageVolume' => 'required|numeric',
            'TotalVolume' => 'required|numeric',
            'Approved' =>'bool'
        ];
    }

}
