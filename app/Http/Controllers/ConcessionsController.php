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

    public function index()
    {
        return view('concessions.index');
    }

    public function create()
    {
        return view('concessions.create');
    }

    public function edit($id)
    {
        return view('concessions.edit', ['id' => $id]);
    }
}
