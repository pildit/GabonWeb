<?php

namespace Modules\ForestResources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteLogbookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Concession' => 'exists:Modules\ForestResources\Entities\Concession,Id',
            'DevelopmentUnit' => 'exists:Modules\ForestResources\Entities\DevelopmentUnit,Id',
            'ManagementUnit' => 'exists:Modules\ForestResources\Entities\ManagementUnit,Id',
            'AnnualAllowableCut' => 'exists:Modules\ForestResources\Entities\AnnualAllowableCut,Id',
            'Company' => 'exists:Modules\Admin\Entities\Company,Id',
            'Hammer' => 'integer',
            'Localization' => '',
            'ReportNo' => '',
            'ReportNote' => '',
            'ObserveAt' => 'date_format:Y-m-d H:i:s',
            'Approved' => 'bool',
            'MobileId'=>'string'
        ];
    }

}
