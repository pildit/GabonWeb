<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateDevelopmentUnitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Name' => 'required|string',
            'Concession' => 'required|integer',
            'Start' => 'required|date',
            'End' => 'required|date',
            'Geometry' => 'required|regex:/\POLYGON\b/',
        ];
    }

}
