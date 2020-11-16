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
            'Lat' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'Lon' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'Geometry' => 'string',
            'GpsAccu' => 'numeric',
            'Approved' => 'bool',
            'MobileId'=>'string|unique:Modules\ForestResources\Entities\AnnualAllowableCutInventory,MobileId',
            'ObserveAt'=>'date'

        ];
    }

}
