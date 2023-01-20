<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$routePrefix = config('app.adminUrl');
$routeNamePrefix = 'admin';

Route::get(config('app.adminUrl'), function () {
    return view('templates.' . config('app.template') . '.pages.admin.home');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get(config('app.adminUrl'), function () {
    return view('templates.' . config('app.template') . '.pages.admin.home');
})
    ->middleware(['auth', 'verified'])
    ->name('admin.home');

Route::get(config('app.adminUrl') . '/template', function () {
    return view(
        'templates.' . config('app.template') . '.pages.admin.template',
        [
            'title' => 'Template',
            'settings' => templateHelper::getTemplateSettings(),
        ]
    );
})
    ->middleware(['auth', 'verified'])
    ->name('admin.template');

/**
 * create a route for a CRUD controller
 *
 * @param $controller
 * @param string $name
 * @param string $object
 * @param string $routePrefix|null
 * @param string $routeNamePrefix|null
 *
 * @return void
 */
function crudRouteCreate(
    $controller,
    $name,
    $object,
    $routePrefix = null,
    $routeNamePrefix = null
) {
    if ($routePrefix !== null) {
        $routePrefix = $routePrefix . '/';
    }
    if ($routeNamePrefix !== null) {
        $routeNamePrefix = $routeNamePrefix . '.';
    }
    //index action
    Route::get("{$routePrefix}{$name}/index", [$controller, 'index'])->name(
        "{$routeNamePrefix}{$name}.index"
    );

    //create action
    Route::get("{$routePrefix}{$name}/create", [$controller, 'create'])->name(
        "{$routeNamePrefix}{$name}.create"
    );
    Route::post("{$routePrefix}{$name}/store", [$controller, 'store'])->name(
        "{$routeNamePrefix}{$name}.store"
    );

    //show action
    Route::get("{$routePrefix}{$name}/show/{{$object}}", [
        $controller,
        'show',
    ])->name("{$routeNamePrefix}{$name}.show");

    //edit action
    Route::get("{$routePrefix}{$name}/edit/{{$object}}", [
        $controller,
        'edit',
    ])->name("{$routeNamePrefix}{$name}.edit");
    Route::post("{$routePrefix}{$name}/update/{{$object}}", [
        $controller,
        'update',
    ])->name("{$routeNamePrefix}{$name}.update");

    //delete action
    Route::post("{$routePrefix}{$name}/destroy/{{$object}}", [
        $controller,
        'destroy',
    ])->name("{$routeNamePrefix}{$name}.destroy");
}

$routesForModels = [
    [\App\Http\Controllers\PageController::class, 'page', 'page'],
    [\App\Http\Controllers\DiscountController::class, 'discount', 'discount'],
    [\App\Http\Controllers\GalleryController::class, 'gallery', 'gallery'],
    [\App\Http\Controllers\ImageController::class, 'image', 'image'],
    [\App\Http\Controllers\PriceController::class, 'price', 'price'],
    [\App\Http\Controllers\CommentController::class, 'comment', 'comment'],
    [\App\Http\Controllers\ProductController::class, 'product', 'product'],
    [\App\Http\Controllers\SeoController::class, 'seo', 'seo'],
    [\App\Http\Controllers\CategoryController::class, 'category', 'category'],
    [\App\Http\Controllers\AdvertController::class, 'advert', 'advert'],
    [\App\Http\Controllers\MenuController::class, 'menu', 'menu'],
    [\App\Http\Controllers\MetaController::class, 'meta', 'meta'],
];

foreach ($routesForModels as $routeForModel) {
    crudRouteCreate(
        $routeForModel[0],
        $routeForModel[1],
        $routeForModel[2],
        $routePrefix,
        $routeNamePrefix
    );
}

//create menu sub item action
Route::get("{$routePrefix}/menu/createSub/{id}", [
    \App\Http\Controllers\MenuController::class,
    'createSub',
])->name("{$routeNamePrefix}.menu.createSub");

// setting home page route
Route::get('/', function () {
    return view('templates.' . config('app.template') . '.pages.guest.home');
})->name('home');

//generating routes for static pages of selected template
$templateSettings = templateHelper::getTemplateSettings();
foreach ($templateSettings['staticPages'] as $staticPage) {
    Route::get('sp/' . $staticPage['route'], function () use ($staticPage) {
        return view(
            'templates.' . config('app.template') . '.' . $staticPage['view']
        );
    })->name('sp.' . $staticPage['name']);
}

Route::middleware('guest')->group(function () {
    Route::get(config('app.adminUrl') . '/login', [
        AuthenticatedSessionController::class,
        'create',
    ])->name('login');
    Route::post(config('app.adminUrl') . '/login', [
        AuthenticatedSessionController::class,
        'store',
    ]);
});

Route::middleware('auth')->group(function () {
    Route::put(config('app.adminUrl') . '/password', [
        PasswordController::class,
        'update',
    ])->name('password.update');
    Route::post(config('app.adminUrl') . '/logout', [
        AuthenticatedSessionController::class,
        'destroy',
    ])->name('logout');
});
