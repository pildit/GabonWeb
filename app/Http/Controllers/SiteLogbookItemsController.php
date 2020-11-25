<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteLogbookItemsController extends Controller
{
    /**
     * Main Page Logbooks
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index () {

        return view('site-logbooks.index');
    }

    /**
     * View Logbooks Items and Logs
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view() {

        return view('site-logbooks.view');
    }
}
