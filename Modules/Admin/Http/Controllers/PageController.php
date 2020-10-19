<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Services\Page;

class PageController extends Controller
{
    public function index(Request $request, Page $pageService)
    {
        $pageService->validateRequest($request);
        $pageService->setPage($request->get('page'));
        $pageService->setPerPage($request->get('per_page'));
        $pageService->setSearch($request->get('search'));

        return response()->json($pageService->getPaginator());
    }
}
