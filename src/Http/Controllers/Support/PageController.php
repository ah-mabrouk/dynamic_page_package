<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Support;

use SolutionPlus\DynamicPages\Filters\Support\PageFilter;
use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Http\Requests\Support\PageStoreRequest;
use SolutionPlus\DynamicPages\Http\Requests\Support\PageUpdateRequest;
use SolutionPlus\DynamicPages\Http\Resources\Support\PageResource;
use SolutionPlus\DynamicPages\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PageFilter $filter)
    {
        $paginationLength = pagination_length(Page::class);
        $pages = Page::filter($filter)->paginate($paginationLength);

        return PageResource::collection($pages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageStoreRequest $request)
    {
        $page = $request->storePage();

        return response([
            'page' => new PageResource($page),
            'message' => __('solutionplus/dynamic_pages/pages.store'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return response([
            'page' => new PageResource($page),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageUpdateRequest $request, Page $page)
    {
        $page = $request->updatePage();

        return response([
            'page' => new PageResource($page),
            'message' => __('solutionplus/dynamic_pages/pages.update'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        if ($page->remove()) {
            return response([
                'message' => __('solutionplus/dynamic_pages/pages.destroy'),
            ]);
        }

        return response([
            'message' => __('solutionplus/dynamic_pages/pages.cant_destroy'),
        ], 409);
    }
}
