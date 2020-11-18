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
        //
    }
}
