<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Admin;

use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Models\Page;
use SolutionPlus\DynamicPages\Models\Section;
use SolutionPlus\DynamicPages\Models\CustomAttribute;
use SolutionPlus\DynamicPages\Filters\Admin\CustomAttributeFilter;
use SolutionPlus\DynamicPages\Http\Resources\Admin\CustomAttributeResource;
use SolutionPlus\DynamicPages\Http\Requests\Admin\CustomAttributeUpdateRequest;

class SectionCustomAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, CustomAttributeFilter $filters)
    {
        $paginationLength = pagination_length(CustomAttribute::class);
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
            'message' => __('solutionplus/dynamic_pages/custom_attributes.update'),
        ]);
    }
}
