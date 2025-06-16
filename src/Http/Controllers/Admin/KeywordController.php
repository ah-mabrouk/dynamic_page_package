<?php

namespace SolutionPlus\Cms\Http\Controllers\Admin;

use SolutionPlus\Cms\Filters\Admin\KeywordFilter;
use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Models\Keyword;
use SolutionPlus\Cms\Http\Requests\Admin\KeywordStoreRequest;
use SolutionPlus\Cms\Http\Requests\Admin\KeywordUpdateRequest;
use SolutionPlus\Cms\Http\Resources\Admin\KeywordResource;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KeywordFilter $filters)
    {
        $paginationLength = pagination_length('Keyword');
        $keywords = Keyword::filter($filters)->paginate($paginationLength);

        return KeywordResource::collection($keywords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KeywordStoreRequest $request)
    {
        $keyword = $request->storeKeyword();

        return response([
            'message' => __('solutionplus/cms/keywords.store'),
            'keyword' => new KeywordResource($keyword),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Keyword $keyword)
    {
        return response([
            'keyword' => new KeywordResource($keyword),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KeywordUpdateRequest $request, Keyword $keyword)
    {
        $request->updateKeyword();

        return response([
            'message' => __('solutionplus/cms/keywords.update'),
            'keyword' => new KeywordResource($keyword),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keyword $keyword)
    {
        if ($keyword->remove()) {
            return response([
                'message' => __('solutionplus/cms/keywords.destroy'),
            ]);
        }

        return response([
            'message' => __('solutionplus/cms/keywords.cant_destroy'),
        ], 409);
    }
}
