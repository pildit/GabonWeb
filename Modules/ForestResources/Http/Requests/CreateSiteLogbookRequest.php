<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSiteLogbookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Concession' => 'required|exists:Modules\ForestResources\Entities\Concession,Id',
            'DevelopmentUnit' => 'required|exists:Modules\ForestResources\Entities\DevelopmentUnit,Id',
            'ManagementUnit' => 'required|exists:Modules\ForestResources\Entities\ManagementUnit,Id',
            'AnnualAllowableCut' => 'required|exists:Modules\ForestResources\Entities\AnnualAllowableCut,Id',
            'Company' => 'required|exists:Modules\Admin\Entities\Company,Id',
            'Hammer' => 'required|integer',
            'Localization' => 'required',
            'ReportNo' => 'required',
            'ReportNote' => 'required',
            'ObserveAt' => 'required|date',
            'Approved' => 'bool',
            'MobileId'=>'string|unique:Modules\ForestResources\Entities\SiteLogbook,MobileId'
        ];
    }

}
