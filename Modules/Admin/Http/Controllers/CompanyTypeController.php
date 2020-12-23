<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GenTux\Jwt\GetsJwtToken;
use Modules\Admin\Entities\CompanyType;

class CompanyTypeController extends Controller
{
    use GetsJwtToken;

    public function __construct()
    {
        $this->middleware('permission:companies.view')->only('listCompanyTypes');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listCompanyTypes(Request $request)
    {
        $company_types = CompanyType::get(['Id', 'Name']);

        return response()->json([
            'data' => $company_types->map(function ($item) {
                return [
                    'Id' => $item->Id,
                    'Name' => $item->Name
                ];
            })
        ]);
    }

}
