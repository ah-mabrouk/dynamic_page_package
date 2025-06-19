<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Website;

use SolutionPlus\DynamicPages\Filters\Website\PageFilter;
use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Http\Resources\Website\PageResource;
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
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $page->load(['sections.media', 'sections.sectionItems.media', 'sections.customAttributes', 'sections.sectionItems.customAttributes']);
        
        return response([
            'page' => new PageResource($page),
        ]);
    }
}
