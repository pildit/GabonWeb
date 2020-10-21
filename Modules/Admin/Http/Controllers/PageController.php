<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Page;
use App\Services\PageResults;

class PageController extends Controller
{
    public function index(Request $request, PageResults $pr)
    {
        return response()->json($pr->getPaginator($request, Page::class , ['name']));
    }
}
