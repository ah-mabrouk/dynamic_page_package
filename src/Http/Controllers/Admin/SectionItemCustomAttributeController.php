<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Admin;

use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Http\Requests\Admin\CustomAttributeUpdateRequest;
use SolutionPlus\DynamicPages\Http\Resources\Admin\CustomAttributeResource;
use SolutionPlus\DynamicPages\Models\CustomAttribute;
use SolutionPlus\DynamicPages\Models\Page;
use SolutionPlus\DynamicPages\Models\Section;
use SolutionPlus\DynamicPages\Models\SectionItem;

class SectionItemCustomAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page, Section $section, SectionItem $section_item)
    {
        $paginationLength = pagination_length('CustomAttribute');
        $customAttributes = $section_item->customAttributes()->paginate($paginationLength);

        return CustomAttributeResource::collection($customAttributes);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Section $section, SectionItem $section_item, CustomAttribute $custom_attribute)
    {
        return response([
            'custom_attribute' => new CustomAttributeResource($custom_attribute),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomAttributeUpdateRequest $request, Page $page, Section $section, SectionItem $section_item, CustomAttribute $custom_attribute)
    {
        $request->updateCustomAttribute();

        return response([
            'message' => __('solutionplus/dynamic_pages/custom_attributes.update'),
            'custom_attribute' => new CustomAttributeResource($custom_attribute),
        ]);
    }
}
