<?php

namespace Modules\Translation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Translation\Entities\Language;
use Modules\Translation\Services\Translation;

class TranslationController extends Controller
{
    /**
     * @param Request $request
     * @param Translation $translation
     * @return JsonResponse
     * @throws \Throwable
     */
    public function index(Request $request, Translation $translation)
    {
        $translation->validateRequest($request);
        $translation->setPage($request->get('page'));
        $translation->setPerPage($request->get('per_page'));

        return response()->json($translation->getPaginator());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return [];
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get the whole dictionary
     *
     * @return JsonResponse
     */
    public function dictionary()
    {
        return response()->json([
            'text_en' => Language::all()->pluck('text_us', 'text_key'),
            'text_fr' => Language::all()->pluck('text_ga', 'text_key')
        ]);
    }
}
