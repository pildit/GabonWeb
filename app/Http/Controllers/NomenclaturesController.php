<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NomenclaturesController extends Controller
{
    public function index($nomenclature_type = null)
    {
        return !is_null($nomenclature_type) && view()->exists($nomenclature_type . ".index") ?
             view($nomenclature_type . ".index") : view('nomenclatures.index');
    }
}
