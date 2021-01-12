<?php

namespace Modules\Transport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "PermitNo" => 'string',
            "PermitNoMobile" => 'unique:Modules\\Transport\\Entities\\Permit,PermitNoMobile',
            "Concession" => 'exists:Modules\ForestResources\Entities\Concession,Id',
            "ManagementUnit" => 'exists:Modules\ForestResources\Entities\ManagementUnit,Id',
            "DevelopmentUnit" => 'exists:Modules\ForestResources\Entities\DevelopmentUnit,Id',
            "AnnualAllowableCut" => 'exists:Modules\ForestResources\Entities\AnnualAllowableCut,Id',
            "ClientCompany" => 'exists:Modules\Admin\Entities\Company,Id',
            "ConcessionaireCompany" => 'exists:Modules\Admin\Entities\Company,Id',
            "TransporterCompany" => 'exists:Modules\Admin\Entities\Company,Id',
            "ProductType" => 'integer',
            "Status" => 'integer',
            "DriverName" => 'string',
            "LicensePlate" => 'string',
            "Province" => 'string',
            "Destination" => 'string',
            "Lat" => [ 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            "Lon" => [ 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            "GpsAccu" => 'integer',
            "MobileId" => 'string',
            "ObserveAt" => 'date_format:Y-m-d H:i:s',
            "Geometry" => 'string',
            "Park" => 'sometimes|required|integer|exists:Modules\Transport\Entities\ParkType,Id',
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
