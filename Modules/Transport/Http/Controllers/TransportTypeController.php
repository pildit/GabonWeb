<?php

namespace Modules\Transport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GenTux\Jwt\GetsJwtToken;
use Modules\Transport\Entities\TransportType;

class TransportTypeController extends Controller
{
    use GetsJwtToken;

    public function __construct()
    {
        $this->middleware('permission:permit.view')->only('listTransportTypes');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listTransportTypes(Request $request)
    {
        $company_types = TransportType::get(['Id', 'Name', 'Parent']);

        return response()->json([
            'data' => $company_types->map(function ($item) {
                return [
                    'Id' => $item->Id,
                    'Name' => $item->Name,
                    'Parent' => $item->Parent
                ];
            })
        ]);
    }

}
