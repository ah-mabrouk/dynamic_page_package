<?php

namespace SolutionPlus\Cms\Http\Controllers\Admin;

use SolutionPlus\Cms\Filters\Admin\KeywordFilter;
use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Models\Page;
use SolutionPlus\Cms\Http\Requests\Admin\PageKeywordStoreRequest;
use SolutionPlus\Cms\Http\Resources\Admin\KeywordResource;
use SolutionPlus\Cms\Http\Resources\Admin\PageResource;

class PageKeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, KeywordFilter $filters)
    {
        $paginationLength = pagination_length('Keyword');
        $keywords = $page->keywords()->filter($filters)->paginate($paginationLength);

        return KeywordResource::collection($keywords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageKeywordStoreRequest $request, Page $page)
    {
        $page = $request->syncKeywords();
        $page->load(['keywords', 'sections']);

        return response([
            'message' => __('solutionplus/cms/pages.update'),
            'page' => new PageResource($page),
        ]);
    }
}
