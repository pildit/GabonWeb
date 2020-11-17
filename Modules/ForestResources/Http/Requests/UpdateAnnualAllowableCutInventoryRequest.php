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
            'TreeId' => 'string',
            'DiameterBreastHeight' => 'numeric',
            'Lat' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'Lon' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'Geometry' => 'string',
            'GpsAccu' => 'numeric',
            'Approved' => 'bool',
            'MobileId'=>'string',
            'ObserveAt'=>'date_format:Y-m-d H:i:s'

        ];
    }

}
