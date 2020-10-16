<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateParcelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Name' => 'required',
            'Geometry' => 'required|regex:/\POLYGON\b/',
        ];
    }

}
