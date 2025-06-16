<?php

use Illuminate\Support\Facades\Route;
use SolutionPlus\Cms\Http\Controllers\Website\PageController;

Route::group([
    'prefix' => config('cms.package_website_routes_prefix'),
    'middleware' => array_unique(array_merge(config('cms.middlewares.website'), [
        'translatable',
    ])),
], function () {
    Route::apiResource('pages', PageController::class, ['only' => ['index', 'show']]);
});
