<?php


namespace App\Http\Controllers;


class AnnualAllowableCutController extends Controller
{
    public function create()
    {
        return view('management.aac.create');
    }

    public function edit($id)
    {
        return view('management.aac.edit', ['id' => $id]);
    }
}
