<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Support;

use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Http\Requests\Support\SectionItemMediaStoreRequest;
use SolutionPlus\DynamicPages\Models\SectionItem;
use Mabrouk\Mediable\Models\Media;
use SolutionPlus\DynamicPages\Http\Resources\Support\SectionItemResource;

class SectionItemMediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionItemMediaStoreRequest $request, SectionItem $section_item)
    {
        if ($section_item->section->item_images_count <= $section_item->media()->count()) {
            abort(409, __('solutionplus/dynamic_pages/section_items.errors.images_exceed_allowed_count'));
        }

        $request->storeSectionItemMedia();

        return response([
            'message' => __('solutionplus/dynamic_pages/section_items.media.store'),
            'section_item' => new SectionItemResource($section_item),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SectionItem $section_item, Media $media)
    {
        $section_item->removeMedia($media);

        return response([
            'message' => __('solutionplus/dynamic_pages/section_items.media.destroy'),
        ]);
    }
}
