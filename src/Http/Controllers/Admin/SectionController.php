<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Admin;

use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Models\Page;
use SolutionPlus\DynamicPages\Models\Section;
use SolutionPlus\DynamicPages\Filters\Admin\SectionFilter;
use SolutionPlus\DynamicPages\Http\Resources\Admin\SectionResource;
use SolutionPlus\DynamicPages\Http\Requests\Admin\SectionUpdateRequest;
use SolutionPlus\DynamicPages\Http\Resources\Admin\SectionSimpleResource;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, SectionFilter $filters)
    {
        $paginationLength = pagination_length(Section::class);
        $sections = $page->sections()->filter($filters)->with('translations')->paginate($paginationLength);

        return SectionSimpleResource::collection($sections);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section)
    {
        $section->load([
            'page.translations',
            'media',
            'customAttributes.translations',
            'sectionItems.translations',
            'sectionItems.customAttributes'
        ]);

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

        return response([
            'message' => __('solutionplus/dynamic_pages/sections.update'),
            'section' => new SectionResource($section),
        ]);
    }
}
