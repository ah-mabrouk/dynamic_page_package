<?php

namespace SolutionPlus\Cms\Http\Controllers\Website;

use SolutionPlus\Cms\Filters\Website\PageFilter;
use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Http\Resources\Website\PageResource;
use SolutionPlus\Cms\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PageFilter $filter)
    {
        $paginationLength = pagination_length('Page');
        $pages = Page::filter($filter)->paginate($paginationLength);

        return PageResource::collection($pages);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $page->load(['sections.images', 'sections.sectionItems.images', 'sections.customAttributes', 'sections.sectionItems.customAttributes']);
        
        return response([
            'page' => new PageResource($page),
        ]);
    }
}
