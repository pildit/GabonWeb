<?php

namespace Modules\ForestResources\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\Quality;
use GenTux\Jwt\GetsJwtToken;
use App\Services\PageResults;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;
use Modules\User\Entities\User;

class QualityController extends Controller
{
    use GetsJwtToken;

    public function __construct()
    {
        $this->middleware('permission:quality.view')->only('index');
        $this->middleware('permission:quality.add|quality.sync')->only('store');
        $this->middleware('permission:quality.edit')->only('update');
    }

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
           'value' => 'required|integer',
           'description' => 'string'
        ]);

        Quality::create([
           'Value' => $data['value'],
           'Description' => $data['description'] ?? null,
           'User'  => $this->JwtPayload('data.id')
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
            'value' => 'integer|required',
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
    public function destroy(Quality $quality)
    {
        $quality->delete();

        return response()->json([
            'message' => lang('quality_delete_successful')
        ], 204);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = ['Value', 'Description', 'User'];
        $collection = Quality::select('Id', 'Value', 'Description', 'User');

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }

        $collection = $collection->get();
        $collection = $collection->map(function ($item) {

            $User = (User::select("firstname","lastname")->where("id", $item->User)->first()) ?
                User::select("firstname")->where("id", $item->User)->first()->firstname ." ".User::select("lastname")->where("id", $item->User)->first()->lastname :
                $item->User;

            return [
                'Value' => $item->Value,
                'Description' => $item->Description,
                'User' => $User
            ];

        });

        return Excel::download(new Exporter($collection,$headings), 'quality.xlsx');
    }
}
