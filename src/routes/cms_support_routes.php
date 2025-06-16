<?php

use Illuminate\Support\Facades\Route;
use SolutionPlus\Cms\Http\Controllers\Support\PageController;
use SolutionPlus\Cms\Http\Controllers\Support\SectionController;
use SolutionPlus\Cms\Http\Controllers\Support\SectionCustomAttributeController;
use SolutionPlus\Cms\Http\Controllers\Support\SectionItemController;
use SolutionPlus\Cms\Http\Controllers\Support\SectionItemCustomAttributeController;
use SolutionPlus\Cms\Http\Controllers\Support\SectionItemMediaController;
use SolutionPlus\Cms\Http\Controllers\Support\SectionMediaController;

Route::group([
    'prefix' => config('cms.package_support_routes_prefix'),
    'middleware' => array_unique(array_merge(config('cms.middlewares.support'), [
        'auth:api',
        'translatable',
    ])),
], function () {
    Route::apiResource('pages', PageController::class);

    Route::apiResource('pages.sections', SectionController::class)->scoped();
    Route::apiResource('sections.medias', SectionMediaController::class)->only(['store','destroy'])->scoped();

    Route::apiResource('pages.sections.custom-attributes', SectionCustomAttributeController::class)->scoped();

    Route::apiResource('pages.sections.section-items', SectionItemController::class)->scoped();
    Route::apiResource('section-items.medias', SectionItemMediaController::class)->only(['store','destroy'])->scoped();

    Route::apiResource('pages.sections.section-items.custom-attributes', SectionItemCustomAttributeController::class)->scoped();
});
