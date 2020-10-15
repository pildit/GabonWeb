<?php

namespace Modules\Transport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePermitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permit_no' => 'required',
            'obsdate' => 'required|date_format:Y-m-d',
            'license_plate' => 'required|alpha_num',
            'transport_comp' => 'required',
            'harvest_name' => 'required',
            'destination' => 'required|in:depot,sawmil,local_community',
            'management_unit' => 'required|in:m3,pieces',
            'operational_unit' => 'required|in:m3,pieces',
            'annual_operational_unit' => 'required',
            'product_type' => 'required|in:logs,transformed',
            'permit_status' => 'required|in:ready,verified,in_transit,transfer_load,end_transport,canceled',
            'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'lon' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
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
