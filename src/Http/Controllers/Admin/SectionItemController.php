<?php

namespace SolutionPlus\Cms\Http\Controllers\Admin;

use SolutionPlus\Cms\Filters\Admin\SectionItemFilter;
use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Http\Requests\Admin\SectionItemUpdateRequest;
use SolutionPlus\Cms\Http\Resources\Admin\SectionItemResource;
use SolutionPlus\Cms\Http\Resources\Admin\SectionItemSimpleResource;
use SolutionPlus\Cms\Models\Page;
use SolutionPlus\Cms\Models\Section;
use SolutionPlus\Cms\Models\SectionItem;

class SectionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, SectionItemFilter $filters)
    {
        $paginationLength = pagination_length('SectionItem');
        $sectionItems = $section->sectionItems()->filter($filters)->paginate($paginationLength);

        return SectionItemSimpleResource::collection($sectionItems);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section, SectionItem $section_item)
    {
        $section_item->load(['section', 'images', 'customAttributes']);
        
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
        $section_item->load(['section', 'images', 'customAttributes']);

        return response([
            'message' => __('solutionplus/cms/section_items.update'),
            'section_item' => new SectionItemResource($section_item),
        ]);
    }
}
