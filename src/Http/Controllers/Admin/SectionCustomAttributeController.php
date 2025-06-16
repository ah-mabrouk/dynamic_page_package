<?php

namespace SolutionPlus\Cms\Http\Controllers\Admin;

use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Models\Page;
use SolutionPlus\Cms\Models\Section;
use SolutionPlus\Cms\Models\CustomAttribute;
use SolutionPlus\Cms\Filters\Admin\CustomAttributeFilter;
use SolutionPlus\Cms\Http\Resources\Admin\CustomAttributeResource;
use SolutionPlus\Cms\Http\Requests\Admin\CustomAttributeUpdateRequest;

class SectionCustomAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, CustomAttributeFilter $filters)
    {
        $paginationLength = pagination_length('CustomAttribute');
        $customAttributes = $section->customAttributes()->filter($filters)->paginate($paginationLength);

        return CustomAttributeResource::collection($customAttributes);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section, CustomAttribute $custom_attribute)
    {
        return response([
            'custom_attribute' => new CustomAttributeResource($custom_attribute),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomAttributeUpdateRequest $request, Page $page, Section $section, CustomAttribute $custom_attribute)
    {
        $request->updateCustomAttribute();

        return response([
            'custom_attribute' => new CustomAttributeResource($custom_attribute),
            'message' => __('solutionplus/cms/custom_attributes.update'),
        ]);
    }
}
