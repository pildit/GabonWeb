<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnualAllowableCutInventoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'AnnualAllowableCut' => 'exists:Modules\ForestResources\Entities\AnnualAllowableCut,Id',
            'Species' => 'integer',
            'Quality' => 'integer',
            'Parcel' => 'exists:Modules\ForestResources\Entities\Parcel,Id',
            'TreeId' => 'text',
            'DiameterBreastHeight' => 'numeric',
        ];
    }

}
