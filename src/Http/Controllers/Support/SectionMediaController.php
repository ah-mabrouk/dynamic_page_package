<?php

namespace SolutionPlus\Cms\Http\Controllers\Support;

use SolutionPlus\Cms\Http\Controllers\Controller;
use SolutionPlus\Cms\Http\Requests\Support\SectionMediaStoreRequest;
use SolutionPlus\Cms\Models\Section;
use Mabrouk\Mediable\Models\Media;
use SolutionPlus\Cms\Http\Resources\Support\SectionResource;

class SectionMediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionMediaStoreRequest $request, Section $section)
    {
        if ($section->images_count <= $section->media()->count()) {
            abort(409, __('solutionplus/cms/sections.errors.images_exceed_allowed_count'));
        }

        $request->storeSectionMedia();
        $section->load(['page', 'images', 'sectionItems', 'customAttributes']);

        return response([
            'message' => __('solutionplus/cms/sections.media.store'),
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
            'message' => __('solutionplus/cms/sections.media.destroy'),
        ]);
    }
}
