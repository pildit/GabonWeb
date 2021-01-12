<?php

namespace Modules\Transport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GenTux\Jwt\GetsJwtToken;
use Modules\Transport\Entities\ParkType;

class ParkTypeController extends Controller
{
    use GetsJwtToken;

    public function __construct()
    {
        $this->middleware('permission:permit.view')->only('listParkTypes');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listParkTypes(Request $request)
    {
        $company_types = ParkType::get(['Id', 'Name']);

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
