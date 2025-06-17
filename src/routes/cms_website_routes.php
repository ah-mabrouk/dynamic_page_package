<?php

use Illuminate\Support\Facades\Route;
use SolutionPlus\Cms\Http\Controllers\Website\PageController;

Route::group([
    'as' => 'website.',
    'prefix' => config('cms.package_website_routes_prefix'),
    'middleware' => array_unique(array_merge(config('cms.middlewares.website'), [
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ])),
], function () {
    Route::apiResource('pages', PageController::class, ['only' => ['index', 'show']]);
});
