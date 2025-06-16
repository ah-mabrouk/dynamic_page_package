<?php

namespace SolutionPlus\Cms\Http\Controllers\Support;

use SolutionPlus\Cms\Filters\Support\SectionFilter;
use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Http\Requests\Support\SectionStoreRequest;
use SolutionPlus\Cms\Http\Requests\Support\SectionUpdateRequest;
use SolutionPlus\Cms\Http\Resources\Support\SectionResource;
use SolutionPlus\Cms\Http\Resources\Support\SectionSimpleResource;
use SolutionPlus\Cms\Models\Page;
use SolutionPlus\Cms\Models\Section;

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
     * Store a newly created resource in storage.
     */
    public function store(SectionStoreRequest $request, Page $page)
    {
        $section = $request->storeSection();

        return response([
            'message' => __('solutionplus/cms/sections.store'),
            'section' => new SectionResource($section),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section)
    {
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
            'message' => __('solutionplus/cms/sections.update'),
            'section' => new SectionResource($section),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page, Section $section)
    {
        if ($section->remove()) {
            return response([
                'message' => __('solutionplus/cms/sections.destroy'),
            ]);
        }

        return response([
            'message' => __('solutionplus/cms/sections.cant_destroy'),
        ], 409);
    }
}
