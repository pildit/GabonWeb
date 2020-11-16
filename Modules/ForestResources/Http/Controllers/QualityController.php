<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\Quality;
use GenTux\Jwt\GetsJwtToken;
use App\Services\PageResults;

class QualityController extends Controller
{
    use GetsJwtToken;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(["Id"]);

        return response()->json($pr->getPaginator($request, Quality::class , ['Value', 'Description']));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
           'value' => 'required|string',
           'description' => 'string'
        ]);

        Quality::create([
           'Value' => $data['value'],
           'Description' => $data['description'] ?? null,
           'UserId'  => $this->JwtPayload('data.id')
        ]);

        return \response()->json([
            'message' => lang('created_successfully')
        ], 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Quality $quality)
    {
        $data = $request->validate([
            'value' => 'string|required',
            'description' => 'string'
        ]);

        $quality->Value = $data['value'];

        if ($request->has('description'))
            $quality->Description = $data['description'];

        $quality->save();

        return response()->json([
            'message' => lang('update_successful')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
