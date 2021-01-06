<?php

namespace Modules\ForestResources\Http\Controllers;

use App\Services\PageResults;
use GenTux\Jwt\GetsJwtToken;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ForestResources\Entities\DevelopmentPlan;
use Modules\ForestResources\Entities\DevelopmentUnit;
use Modules\ForestResources\Entities\Species;
use Modules\ForestResources\Http\Requests\CreateDevelopmentPlanRequest;
use Modules\ForestResources\Http\Requests\UpdateDevelopmentPlanRequest;
use Modules\ForestResources\Services\DevelopmentPlan as DevelopmentPlanService;
use Modules\ForestResources\Exports\Exporter;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Approve;


class DevelopmentPlanController extends Controller
{
    use Approve, GetsJwtToken;
    private $modelName = DevelopmentPlan::class;

    public function __construct()
    {
        $this->middleware('permission:development-unit.view')->only('show','index');
        $this->middleware('permission:development-unit.add|development-unit.sync')->only('store');
        $this->middleware('permission:development-unit.edit')->only('update');
        $this->middleware('permission:development-unit.approve')->only('approve');

//        $this->middleware('role:admin')->only('delete');

    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, PageResults $pr,$DevelopmentUnit)
    {
        $pr->setSortFields(['Id']);
        if(!$DevelopmentUnit){
            throw ValidationException::withMessages(['DevelopmentUnit' => 'validation.exists']);
        }
        $pr->setWhere(['DevelopmentUnit' => $DevelopmentUnit]);

        return response()->json(
            $pr->getPaginator($request, DevelopmentPlan::class,[
                'Species', 'MinimumExploitableDiameter', 'VolumeTariff', 'Increment', 'CreatedAt'
            ])
        );
    }

    /**
     * Store developmentplan
     * @param CreateDevelopmentPlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateDevelopmentPlanRequest $request)
    {
        $data = $request->validated();
        if (DevelopmentPlan::where('DevelopmentUnit', $data['DevelopmentUnit'])->where('Species', $data['Species'])->count() > 0) {
            return response()->json([
                'message' => lang("developmentplan_developmentunit_species_exist")
            ], 422);
        }

        $developmentplan = DevelopmentPlan::create($data);

        return response()->json([
            'message' => lang("developmentplan_created_successfully")
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DevelopmentPlan $developmentplan)
    {
        return response()->json(['data' => $developmentplan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDevelopmentPlanRequest $request
     * @param DevelopmentPlan $development_plan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDevelopmentPlanRequest $request, DevelopmentPlan $development_plan)
    {
        $data = $request->validated();

        if (DevelopmentPlan::where('DevelopmentUnit', $data['DevelopmentUnit'])->where('Species', $data['Species'])->where('Id', '!=', $development_plan->Id)->count() > 0) {
            throw  ValidationException::withMessages(['development_unit' => lang("developmentplan_developmentunit_species_exist")]);
        } elseif( DevelopmentPlan::where('DevelopmentUnit', $data['DevelopmentUnit'])->where('Species', $data['Species'])->where('Id', '=', $development_plan->Id)->count() > 0) {
            unset($data['DevelopmentUnit']);
            unset($data['Species']);
        }

        $development_plan->update($data);

        return response()->json([
            'message' => lang('developmentplan_update_successful')
        ], 200);

    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(DevelopmentPlan $developmentplan)
    {
        $developmentplan->delete();

        return response()->json([
            'message' => lang('developmentplan_delete_successful')
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

        $headings = ['DevelopmentUnit','Species','MinimumExploitableDiameter','VolumeTariff','Increment'];
        $collection = DevelopmentPlan::select('Id','DevelopmentUnit','Species','MinimumExploitableDiameter','VolumeTariff','Increment');

        if ($request->get('date_from')) {
            $collection = $collection->where("CreatedAt", ">=", $request->get('date_from'));
        }
        if ($request->get('date_to')) {
            $collection = $collection->where("CreatedAt", "<=", $request->get('date_to'));
        }
        $collection = $collection->get();

        $collection = $collection->map(function ($item) {

            $DevelopmentUnit = (DevelopmentUnit::select("Name")->where("Id", $item->DevelopmentUnit)->first()) ?
                    DevelopmentUnit::select("Name")->where("Id", $item->DevelopmentUnit)->first()->Name :
                    $item->DevelopmentUnit;

            $Species = (Species::select("CommonName")->where("Id", $item->Species)->first()) ?
                Species::select("CommonName")->where("Id", $item->Species)->first()->CommonName :
                $item->Species;

            return [
                'DevelopmentUnit'=>$DevelopmentUnit,
                'Species'=>$Species,
                'MinimumExploitableDiameter'=>$item->MinimumExploitableDiameter,
                'VolumeTariff'=>$item->VolumeTariff,
                'Increment'=>$item->Increment
            ];
        });

        return Excel::download(new Exporter($collection, $headings), 'development_plan.xlsx');
    }
}
