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
            'obsdate' => 'date_format:Y-m-d',
            'license_plate' => 'alpha_num',
            'destination' => 'in:depot,sawmil,local_community',
            'management_unit' => 'in:m3,pieces',
            'operational_unit' => 'in:m3,pieces',
            'product_type' => 'in:logs,transformed',
            'permit_status' => 'in:ready,verified,in_transit,transfer_load,end_transport,canceled',
            'lat' => 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/',
            'lon' => 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/',
            'gps_accu' => 'numeric'
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
