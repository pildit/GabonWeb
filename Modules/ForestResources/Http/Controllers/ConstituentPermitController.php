<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Contracts\Support\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\ConstituentPermit;
use App\Services\PageResults;
use Modules\ForestResources\Http\Requests\CreateConstituentPermitRequest;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class ConstituentPermitController extends Controller
{
    use GetsJwtToken;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(['Id']);

        return response()->json($pr->getPaginator($request, ConstituentPermit::class , ['Email']));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreateConstituentPermitRequest $request)
    {
        $data = $request->validated();        

        $constituent_permit = new ConstituentPermit;
        $constituent_permit->PermitType = $data['permit_type'];
        $constituent_permit->PermitNumber = $data['permit_number'];
        $constituent_permit->User = $this->jwtPayload('data.id');

        $constituent_permit->save();

        return response()->json([
            'message' => lang("created_successfully")
        ], 201);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(ConstituentPermit $constituent_permit)
    {
        return response()->json(['data' => $constituent_permit], 200);    
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param ConstituentPermit $cp
     * @return Response
     */
    public function update(Request $request, ConstituentPermit $cp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(ConstituentPermit $constituent_permit)
    {
        $constituent_permit->delete();

        return response()->json([
            'message' => lang('Delete succesful')
        ], 204);
    }
}
