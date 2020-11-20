<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\ForestResources\Entities\DevelopmentPlan;

class UpdateDevelopmentPlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'DevelopmentUnit' => 'exists:Modules\ForestResources\Entities\DevelopmentUnit,Id',
            'Species' => 'integer',
            'MinimumExploitableDiameter' => 'numeric',
            'VolumeTariff' => 'string',
            'Increment' => ['regex:/^(?:[1-9]\d+|\d)(?:\.\d\d)?(?:\,\d\d)?$/'],
            'Approved' => 'bool'
        ];
    }

}
