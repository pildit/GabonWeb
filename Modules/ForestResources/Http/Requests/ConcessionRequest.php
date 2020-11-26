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
            'Number' => 'string|required|sometimes',
            'Name' => 'string|required|sometimes',
            'Company' => 'integer|required|sometimes', // exists:pgsql.admin.companies,id',
            'Continent' => 'string|required|sometimes', //exists:Taxonomy.continents,id',
            'ProductType' => 'sometimes|required|integer|exists:Modules\ForestResources\Entities\ProductType,Id',
            'Geometry' => 'string|required',
            'ConstituentPermit' => 'integer|required|sometimes|exists:pgsql.ForestResources.ConstituentPermits,Id',
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
