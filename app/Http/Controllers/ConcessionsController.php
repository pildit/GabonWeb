<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConcessionsController extends Controller
{
    public function index($resource_type = null)
    {
        return !is_null($resource_type) && view()->exists($resource_type . ".index") ?
            view($resource_type . ".index") : view('concessions.index');
    }
}
