<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnnualAllowableCutInventoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'AnnualAllowableCut' => 'required|exists:Modules\ForestResources\Entities\AnnualAllowableCut,Id',
            'Species' => 'required|integer',
            'Quality' => 'required|integer',
            'Parcel' => 'required|exists:Modules\ForestResources\Entities\Parcel,Id',
            'TreeId' => 'required|string',
            'DiameterBreastHeight' => 'required|numeric',
        ];
    }

}
