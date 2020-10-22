<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConstituentPermitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permit_type' => 'required|exists:pgsql.ForestResources.PermitTypes,Id',
            'permit_number' => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
