<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\CompanyType;
use Modules\Admin\Entities\Company;
use Modules\Admin\Http\Requests\CreateCompanyRequest;
use GenTux\Jwt\GetsJwtToken;

class CompanyController extends Controller
{
    use GetsJwtToken;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, PageResults $pageResults)
    {
        $pageResults->setSortFields(['Id']);
        return response()->json($pageResults->getPaginator($request, Company::class , ['Name'], ['types', 'user']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CreateCompanyRequest $request)
    {
        $data = $request->validated();

        $company = new Company;

        $company->Name = $data['name'];
        $company->GroupName = $data['group-name'] ?? null;
        $company->UserId = $this->jwtPayload('data.id');

        $company->save();

        if ($request->has('types')) {
            $company->types()->attach($data['types']);
        }

        return response()->json([
            'message' => lang("Create succesful")
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CreateCompanyRequest $request, Company $company)
    {
        $data = $request->validated();

        $company->Name = $data['name'];
        $company->GroupName = $data['group-name'] ?? null;

        $company->save();

        if ($request->has('types')) {
                $company->types()->sync($data['types']);
        }


        return response()->json([
            'message' => lang("Update succesful")
        ], 201);
    }

    public function show(Company $company)
    {
        return response()->json([
           'data' => $company
        ]);
    }
}
