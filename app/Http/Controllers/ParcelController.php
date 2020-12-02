<?php


namespace App\Http\Controllers;


class ParcelController extends Controller
{
    public function create()
    {
        return view('management.parcels.create');
    }

    public function edit($id)
    {
        return view('management.parcels.edit', ['id' => $id]);
    }
}
