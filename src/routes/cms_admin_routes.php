<?php

use Illuminate\Support\Facades\Route;
use SolutionPlus\Cms\Http\Controllers\Admin\KeywordController;
use SolutionPlus\Cms\Http\Controllers\Admin\PageController;
use SolutionPlus\Cms\Http\Controllers\Admin\PageKeywordController;
use SolutionPlus\Cms\Http\Controllers\Admin\SectionController;
use SolutionPlus\Cms\Http\Controllers\Admin\SectionCustomAttributeController;
use SolutionPlus\Cms\Http\Controllers\Admin\SectionItemController;
use SolutionPlus\Cms\Http\Controllers\Admin\SectionItemCustomAttributeController;
use SolutionPlus\Cms\Http\Controllers\Admin\SectionItemMediaController;
use SolutionPlus\Cms\Http\Controllers\Admin\SectionMediaController;

Route::group([
    'as' => 'admin.',
    'prefix' => config('cms.package_admin_routes_prefix'),
    'middleware' => array_unique(array_merge(config('cms.middlewares.admin'), [
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ])),
], function () {
    Route::apiResource('pages', PageController::class)->except(['store', 'destroy']);
    Route::apiResource('keywords', KeywordController::class);
    Route::apiResource('pages.keywords', PageKeywordController::class)->only(['index', 'store'])->scoped();

    Route::apiResource('pages.sections', SectionController::class)->except(['store', 'destroy'])->scoped();
    Route::apiResource('sections.medias', SectionMediaController::class)->only(['store', 'destroy'])->scoped();

    Route::apiResource('pages.sections.custom-attributes', SectionCustomAttributeController::class)->except(['store', 'destroy'])->scoped();

    Route::apiResource('pages.sections.section-items', SectionItemController::class)->except(['store', 'destroy'])->scoped();
    Route::apiResource('section-items.medias', SectionItemMediaController::class)->only(['store', 'destroy'])->scoped();

    Route::apiResource('pages.sections.section-items.custom-attributes', SectionItemCustomAttributeController::class)->except(['store', 'destroy'])->scoped();

});
