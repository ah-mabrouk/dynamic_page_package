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
        $pages = Page::filter($filter)->with([
            'translations',
            'sections.translations',
            'sections.media',
            'sections.customAttributes.translations',
            'sections.sectionItems.translations',
            'sections.sectionItems.media',
            'sections.sectionItems.customAttributes.translations',
            'visibleKeywords.translations',
        ])->paginate($paginationLength);

        return PageResource::collection($pages);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $page->load([
            'translations',
            'sections.translations',
            'sections.media',
            'sections.customAttributes.translations',
            'sections.sectionItems.translations',
            'sections.sectionItems.media',
            'sections.sectionItems.customAttributes.translations',
            'visibleKeywords.translations',
        ]);

        return response([
            'page' => new PageResource($page),
        ]);
    }
}
