<?php

namespace SolutionPlus\Cms\Http\Controllers\Admin;

use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Http\Requests\Admin\SectionItemMediaStoreRequest;
use SolutionPlus\Cms\Models\SectionItem;
use Mabrouk\Mediable\Models\Media;
use SolutionPlus\Cms\Http\Resources\Admin\SectionItemResource;

class SectionItemMediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionItemMediaStoreRequest $request, SectionItem $section_item)
    {
        if ($section_item->section->item_images_count <= $section_item->media()->count()) {
            abort(409, __('solutionplus/cms/section_items.errors.images_exceed_allowed_count'));
        }

        $sectionItem = $request->storeSectionItemMedia();

        return response([
            'message' => __('solutionplus/cms/section_items.media.store'),
            'section_item' => new SectionItemResource($sectionItem),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SectionItem $section_item, Media $media)
    {
        $section_item->removeMedia($media);

        return response([
            'message' => __('solutionplus/cms/section_items.media.destroy'),
        ]);
    }
}
