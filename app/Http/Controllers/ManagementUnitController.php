<?php


namespace App\Http\Controllers;


use Modules\ForestResources\Entities\ManagementUnit;

class ManagementUnitController extends Controller
{
    public function create()
    {
        return view('management.management-units.create');
    }

    public function edit($id)
    {
        return view('management.management-units.edit', ['id' => $id]);
    }

    public function plans($id){
        return view('management.management-units.plans', ['id' => $id]);
    }
}
