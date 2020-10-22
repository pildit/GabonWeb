<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConcessionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Name' => 'string|required',
            'Company' => 'integer|required|', // exists:pgsql.admin.companies,id',
            'Continent' => 'integer|required|', //exists:Taxonomy.continents,id',
            'Geometry' => 'required',
            'ConstituentPermit' => 'integer|required|exists:pgsql.ForestResources.ConstituentPermits,Id'
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
