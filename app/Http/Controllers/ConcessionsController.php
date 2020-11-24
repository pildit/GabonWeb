<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConcessionsController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function resources()
    {
        return view('concessions.resources');
    }

    public function parcels()
    {
        return view('parcels.index');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function edit($id)
    {
        //
    }
}
