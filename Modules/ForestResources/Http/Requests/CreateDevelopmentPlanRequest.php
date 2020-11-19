<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDevelopmentPlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'DevelopmentUnit' => 'required|exists:Modules\ForestResources\Entities\DevelopmentUnit,Id',
            'Species' => 'required|integer',
            'MinimumExploitableDiameter' => 'required|string',
            'VolumeTariff' => 'string',
            'Increment' => ['regex:/^(?:[1-9]\d+|\d)(?:\.\d\d)?(?:\,\d\d)?$/'],
            'Approved' => 'bool'
        ];
    }

}
