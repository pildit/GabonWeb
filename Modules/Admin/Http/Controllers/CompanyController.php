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
use Modules\Transport\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{
    use GetsJwtToken;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param PageResults $pageResults
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, PageResults $pageResults)
    {
        $pageResults->setSortFields(['Id']);
        return response()->json($pageResults->getPaginator($request, Company::class , ['Name']));
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
        $company->TradeRegister = $data['trade-register'] ?? null;

        $company->User = $this->jwtPayload('data.id');

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
        $company->TradeRegister = $data['trade-register'] ?? null;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listCompanies(Request $request)
    {
        $companies = Company::where('Name', 'ilike', "%{$request->get('name')}%")
            ->take($request->get('limit', 100))
            ->get(['Id', 'Name']);

        return response()->json([
           'data' => $companies->map(function ($company) {
               return [
                   'Id' => $company->Id,
                   'Name' => $company->Name
               ];
           })
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function export(Request $request)
    {
        $request->validate(['date_from' => 'nullable|date_format:Y-m-d']);
        $request->validate(['date_to' => 'nullable|date_format:Y-m-d']);

        $headings  = ["Name"];
        $collection = Company::select("Id","Name");

        if($request->get('date_from')){
            $collection = $collection->where("CreatedAt",">=",$request->get('date_from'));
        }
        if($request->get('date_to')){
            $collection = $collection->where("CreatedAt","<=",$request->get('date_to'));
        }

        $collection = $collection->get();
        $collection = $collection->map(function ($item) {

            return [
                "Name"=>$item->Name,

            ];
        });

        return Excel::download(new Exporter($collection,$headings), 'company.xlsx');
    }
}
