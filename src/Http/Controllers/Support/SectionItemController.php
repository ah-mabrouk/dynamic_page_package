<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Support;

use SolutionPlus\DynamicPages\Filters\Support\SectionItemFilter;
use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Http\Requests\Support\SectionItemStoreRequest;
use SolutionPlus\DynamicPages\Http\Requests\Support\SectionItemUpdateRequest;
use SolutionPlus\DynamicPages\Http\Resources\Support\SectionItemResource;
use SolutionPlus\DynamicPages\Http\Resources\Support\SectionItemSimpleResource;
use SolutionPlus\DynamicPages\Models\Page;
use SolutionPlus\DynamicPages\Models\Section;
use SolutionPlus\DynamicPages\Models\SectionItem;

class SectionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, SectionItemFilter $filter)
    {
        $paginationLength = pagination_length(SectionItem::class);
        $sectionItems = $section->sectionItems()->filter($filter)->with('translations')->paginate($paginationLength);

        return SectionItemSimpleResource::collection($sectionItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionItemStoreRequest $request, Page $page, Section $section)
    {
        $sectionItem = $request->sectionItemStore();

        return response([
            'message' => __('solutionplus/dynamic_pages/section_items.store'),
            'section_item' => new SectionItemResource($sectionItem),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section, SectionItem $section_item)
    {
        $section_item->load([
            'section.translations'
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page, Section $section, SectionItem $section_item)
    {
        if ($section_item->remove()) {
            return response([
                'message' => __('solutionplus/dynamic_pages/section_items.destroy'),
            ]);
        }

        return response([
            'message' => __('solutionplus/dynamic_pages/section_items.cant_destroy'),
        ], 409);
    }
}
