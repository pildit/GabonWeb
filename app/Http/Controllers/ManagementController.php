<?php


namespace App\Http\Controllers;


class ManagementController extends Controller
{
    public function index($management_type = null)
    {
        return !is_null($management_type) && view()->exists( "management.{$management_type}.index") ?
            view("management.{$management_type}.index") : view('management.index');
    }
}
