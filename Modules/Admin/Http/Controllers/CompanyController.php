<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Admin\Entities\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = Company::all();

        return response()->json([
            'data' => $data, 
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required'
        ]);

        Company::create($data);

        return response()->json([
            'message' => lang("Create succesful")
        ], 201);        
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'string|required'
        ]);
    
        $company->name = $data['name'];
        $company->save();


        return response()->json([
            'message' => lang("Update succesful")
        ], 201);
    }


}
