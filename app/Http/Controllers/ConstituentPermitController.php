<?php


namespace App\Http\Controllers;


class ConstituentPermitController extends Controller
{
    public function create()
    {
        return view('constituent-permits.create');
    }

    public function edit($id)
    {
        return view('constituent-permits.edit', ['id' => $id]);
    }
}
