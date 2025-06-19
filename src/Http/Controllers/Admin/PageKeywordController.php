<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Admin;

use SolutionPlus\DynamicPages\Filters\Admin\KeywordFilter;
use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Models\Keyword;
use SolutionPlus\DynamicPages\Models\Page;
use SolutionPlus\DynamicPages\Http\Requests\Admin\PageKeywordStoreRequest;
use SolutionPlus\DynamicPages\Http\Resources\Admin\KeywordResource;
use SolutionPlus\DynamicPages\Http\Resources\Admin\PageResource;

class PageKeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, KeywordFilter $filters)
    {
        $paginationLength = pagination_length(Keyword::class);
        $keywords = $page->keywords()->filter($filters)->paginate($paginationLength);

        return KeywordResource::collection($keywords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageKeywordStoreRequest $request, Page $page)
    {
        $page = $request->syncKeywords();

        return response([
            'message' => __('solutionplus/dynamic_pages/pages.update'),
            'page' => new PageResource($page),
        ]);
    }
}
