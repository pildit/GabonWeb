<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDevelopmentUnitRequest extends FormRequest
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
            'Start' => 'required|date_format:Y-m-d H:i:s',
            'End' => 'required|date_format:Y-m-d H:i:s',
            'Geometry' => 'string',
            'Approved'=>'bool',
        ];
    }

}
