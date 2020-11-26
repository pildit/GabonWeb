<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\ProductType;
use Maatwebsite\Excel\Facades\Excel;
use Modules\User\Entities\User;
use Modules\ForestResources\Exports\Exporter;

class ProductTypeController extends Controller
{
    use GetsJwtToken;

    public function __construct()
    {
//        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request, PageResults $pr)
    {
        $pr->setSortFields(["Id"]);

        return response()->json($pr->getPaginator($request, ProductType::class , ['Name']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        ProductType::create([
            'Name' => $data['name'],
            'User' => $this->jwtPayload('data.id')
        ]);

        return \response()->json([
            'message' => lang('created_successfully')
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ProductType  $productType)
    {
        $data = $request->validate([
            'name' => 'string|required'
        ]);

        $productType->Name = $data['name'];


        $productType->save();

        return response()->json([
            'message' => lang('update_successful')
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = ['Name', 'User'];
        $collection = ProductType::select('Id', 'Name', 'User');

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
                'Name' => $item->Name,
                'User' => $User
            ];

        });

        return Excel::download(new Exporter($collection,$headings), 'product_type.xlsx');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listProductTypes()
    {
        $productTypes = ProductType::all(['Id', 'Name']);

        return response()->json([
            'data' => $productTypes->map(function ($productType) {
                return [
                    'Id' => $productType->Id,
                    'Name' => $productType->Name
                ];
            })
        ]);
    }
}
