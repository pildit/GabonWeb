<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\ProductType;

class ProductTypeController extends Controller
{
    use GetsJwtToken;

    public function __construct()
    {
        $this->middleware('role:admin');
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
            'UserId' => $this->jwtPayload('data.id')
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
}
