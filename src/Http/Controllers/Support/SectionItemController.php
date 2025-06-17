<?php

namespace SolutionPlus\Cms\Http\Controllers\Support;

use SolutionPlus\Cms\Filters\Support\SectionItemFilter;
use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Http\Requests\Support\SectionItemStoreRequest;
use SolutionPlus\Cms\Http\Requests\Support\SectionItemUpdateRequest;
use SolutionPlus\Cms\Http\Resources\Support\SectionItemResource;
use SolutionPlus\Cms\Http\Resources\Support\SectionItemSimpleResource;
use SolutionPlus\Cms\Models\Page;
use SolutionPlus\Cms\Models\Section;
use SolutionPlus\Cms\Models\SectionItem;

class SectionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, SectionItemFilter $filter)
    {
        $paginationLength = pagination_length('SectionItem');
        $sectionItems = $section->sectionItems()->filter($filter)->paginate($paginationLength);

        return SectionItemSimpleResource::collection($sectionItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionItemStoreRequest $request, Page $page, Section $section)
    {
        $sectionItem = $request->sectionItemStore();

        return response([
            'message' => __('solutionplus/cms/section_items.store'),
            'section_item' => new SectionItemResource($sectionItem),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section, SectionItem $section_item)
    {
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
            'message' => __('solutionplus/cms/section_items.update'),
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
                'message' => __('solutionplus/cms/section_items.destroy'),
            ]);
        }

        return response([
            'message' => __('solutionplus/cms/section_items.cant_destroy'),
        ], 409);
    }
}
