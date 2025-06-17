<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Admin;

use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Models\Page;
use SolutionPlus\DynamicPages\Filters\Admin\PageFilter;
use SolutionPlus\DynamicPages\Http\Resources\Admin\PageResource;
use SolutionPlus\DynamicPages\Http\Requests\Admin\PageUpdateRequest;
use SolutionPlus\DynamicPages\Http\Resources\Admin\PageSimpleResource;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PageFilter $filter)
    {
        $paginationLength = pagination_length('Page');
        $pages = Page::filter($filter)->paginate($paginationLength);

        return PageSimpleResource::collection($pages);
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
}
