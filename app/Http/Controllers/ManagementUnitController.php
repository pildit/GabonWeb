<?php


namespace App\Http\Controllers;


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
}
