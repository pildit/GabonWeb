<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDevelopmentUnitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Name' => 'string',
            'Concession' => 'integer',
            'Start' => 'date_format:Y-m-d H:i:s',
            'End' => 'date_format:Y-m-d H:i:s',
            'Geometry' => 'string',
            'Approved'=>'bool',
        ];
    }

}
