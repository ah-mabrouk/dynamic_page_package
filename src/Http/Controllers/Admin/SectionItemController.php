<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Admin;

use SolutionPlus\DynamicPages\Filters\Admin\SectionItemFilter;
use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Http\Requests\Admin\SectionItemUpdateRequest;
use SolutionPlus\DynamicPages\Http\Resources\Admin\SectionItemResource;
use SolutionPlus\DynamicPages\Http\Resources\Admin\SectionItemSimpleResource;
use SolutionPlus\DynamicPages\Models\Page;
use SolutionPlus\DynamicPages\Models\Section;
use SolutionPlus\DynamicPages\Models\SectionItem;

class SectionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, SectionItemFilter $filters)
    {
        $paginationLength = pagination_length(SectionItem::class);
        $sectionItems = $section->sectionItems()->filter($filters)->with('translations')->paginate($paginationLength);

        return SectionItemSimpleResource::collection($sectionItems);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section, SectionItem $section_item)
    {
        $section_item->load([
            'section.translations',
            'media',
            'customAttributes.translations'
        ]);

        return response([
            'section_item' => new SectionItemResource($section_item),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionItemUpdateRequest $request, Page $page, Section $section, SectionItem $section_item)
    {
        $request->sectionItemUpdate();

        return response([
            'message' => __('solutionplus/dynamic_pages/section_items.update'),
            'section_item' => new SectionItemResource($section_item),
        ]);
    }
}
