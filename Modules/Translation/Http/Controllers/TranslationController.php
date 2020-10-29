<?php

namespace Modules\Translation\Http\Controllers;

use App\Services\PageResults;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Translation\Entities\Language;
use Modules\Translation\Http\Requests\CreateTranslationKeyRequest;
use Modules\Translation\Http\Requests\UpdateTranslationKeyRequest;
use Modules\Translation\Services\Translation;

class TranslationController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:translations.view', ['only' => 'index']);
    }

    /**
     * @param Request $request
     * @param Translation $translation
     * @return JsonResponse
     * @throws \Throwable
     */
    public function index(Request $request, PageResults $pageResults)
    {
        return response()->json($pageResults->getPaginator($request, Language::class , ['text_key', 'text_us', 'text_ga']));
    }

    /**
     * @param Request $request
     * @param Translation $transService
     * @return JsonResponse
     */
    public function store(CreateTranslationKeyRequest $request, Translation $transService)
    {
        $result = $transService->store($request->all());

        return response()->json([
            'data' => $result
        ], 201);
    }

    /**
     * @param Language $language
     * @return JsonResponse
     */
    public function show(Language $translation)
    {
        return response()->json([
            'data' => $translation
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateTranslationKeyRequest $request, Language $translation)
    {
        $result = $translation->update($request->all());

        return response()->json([
           'data' => $result
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $translation
     * @return JsonResponse
     */
    public function destroy(Language $translation)
    {
        $translation->delete();

        return response()->json([
            'message' => lang('delete_success')
        ]);
    }

    /**
     * Get the whole dictionary
     *
     * @return JsonResponse
     */
    public function dictionary(Request $request)
    {
        $request->validate([
            'mobile' => 'boolean'
        ]);

        $language = Language::query();

        if($request->has('mobile')) {
            $language->where('mobile', $request->get('mobile'));
        }

        return response()->json([
            "data" => [
                'text_en' => $language->get()->pluck('text_us', 'text_key'),
                'text_fr' => $language->get()->pluck('text_ga', 'text_key')
            ]
        ]);
    }
}
