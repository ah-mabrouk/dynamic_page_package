<?php

namespace SolutionPlus\Cms\Http\Controllers\Admin;

use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Models\Page;
use SolutionPlus\Cms\Models\Section;
use SolutionPlus\Cms\Filters\Admin\SectionFilter;
use SolutionPlus\Cms\Http\Resources\Admin\SectionResource;
use SolutionPlus\Cms\Http\Requests\Admin\SectionUpdateRequest;
use SolutionPlus\Cms\Http\Resources\Admin\SectionSimpleResource;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, SectionFilter $filters)
    {
        $paginationLength = pagination_length('Section');
        $sections = $page->sections()->filter($filters)->paginate($paginationLength);

        return SectionSimpleResource::collection($sections);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section)
    {
        $section->load(['page', 'images', 'sectionItems', 'customAttributes']);
        
        return response([
            'section' => new SectionResource($section),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionUpdateRequest $request, Page $page, Section $section)
    {
        $request->updateSection();
        $section->load(['page', 'images', 'sectionItems', 'customAttributes']);

        return response([
            'message' => __('solutionplus/cms/sections.update'),
            'section' => new SectionResource($section),
        ]);
    }
}
