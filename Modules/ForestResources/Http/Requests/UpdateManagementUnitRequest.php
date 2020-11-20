<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManagementUnitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Number' => 'string',
            'Name' => 'string',
            'DevelopmentUnit' => 'exists:Modules\ForestResources\Entities\DevelopmentUnit,Id',
            'Geometry' => 'string',
        ];
    }

}
