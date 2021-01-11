<?php


namespace App\Http\Controllers;


class DevelopmentUnitController extends Controller
{
    public function create()
    {
        return view('management.development-units.create');
    }

    public function edit($id)
    {
        return view('management.development-units.edit', ['id' => $id]);
    }

    public function plans($id){
        return view('management.development-units.plans', ['id' => $id]);
    }
}
