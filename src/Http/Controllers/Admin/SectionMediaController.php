<?php

namespace SolutionPlus\DynamicPages\Http\Controllers\Admin;

use SolutionPlus\DynamicPages\Http\Controllers\Controller;
use SolutionPlus\DynamicPages\Http\Requests\Admin\SectionMediaStoreRequest;
use SolutionPlus\DynamicPages\Models\Section;
use Mabrouk\Mediable\Models\Media;
use SolutionPlus\DynamicPages\Http\Resources\Admin\SectionResource;

class SectionMediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionMediaStoreRequest $request, Section $section)
    {
        if ($section->images_count <= $section->media()->count()) {
            abort(409, __('solutionplus/dynamic_pages/sections.errors.images_exceed_allowed_count'));
        }

        $request->storeSectionMedia();

        return response([
            'message' => __('solutionplus/dynamic_pages/sections.media.store'),
            'section' => new SectionResource($section),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section, Media $media)
    {
        $section->removeMedia($media);

        return response([
            'message' => __('solutionplus/dynamic_pages/sections.media.destroy'),
        ]);
    }
}
