<?php

namespace Modules\ForestResources\Http\Controllers;

use GenTux\Jwt\GetsJwtToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\PermitType;
use App\Services\PageResults;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;
use Modules\User\Entities\User;

class PermitTypesController extends Controller
{
    use GetsJwtToken;

    public function __construct()
    {
//        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(["Id"]);

        return response()->json($pr->getPaginator($request, PermitType::class , ['Abbreviation']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'abbreviation' => 'string|required|unique:\Modules\ForestResources\Entities\PermitType,Abbreviation',
            'name' => 'string'
        ]);

        PermitType::create([
            'Abbreviation' => $data['abbreviation'],
            'Name' => $data['name'] ?? null,
            'User' => $this->JwtPayload('data.id')
            ]);

        return response()->json([
            'message' => lang('created_successfully')
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, PermitType $permit_type)
    {
        $data = $request->validate([
            'abbreviation' => 'string|required',
            'name' => 'string'
        ]);

        $permit_type->Abbreviation = $data['abbreviation'];

        if ($request->has('name'))
            $permit_type->Name = $data['name'];

        $permit_type->save();

        return response()->json([
            'message' => lang('update_successful')
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = ['Abbreviation', 'Name', 'User'];
        $collection = PermitType::select('Id','Abbreviation',  'Name', 'User');

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
                'Abbreviation' => $item->Abbreviation,
                'Name' => $item->Name,
                'User' => $User
            ];

        });

        return Excel::download(new Exporter($collection,$headings), 'permit_type.xlsx');
    }
}
