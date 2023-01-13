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

Route::get('/', [Controller::class, 'home'])->name('home');

Route::get('dashboard', [Controller::class, 'home'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get(config('app.adminUrl'), [Controller::class, 'adminHome'])
    ->middleware(['auth', 'verified'])
    ->name('admin.home');

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

crudRouteCreate(
    \App\Http\Controllers\CommentController::class,
    'page',
    'page',
    config('app.adminUrl'),
    'admin'
);
crudRouteCreate(
    \App\Http\Controllers\DiscountController::class,
    'discount',
    'discount',
    config('app.adminUrl'),
    'admin'
);
crudRouteCreate(
    \App\Http\Controllers\GalleryController::class,
    'gallery',
    'gallery',
    config('app.adminUrl'),
    'admin'
);
crudRouteCreate(
    \App\Http\Controllers\ImageController::class,
    'image',
    'image',
    config('app.adminUrl'),
    'admin'
);
crudRouteCreate(
    \App\Http\Controllers\PageController::class,
    'page',
    'page',
    config('app.adminUrl'),
    'admin'
);
crudRouteCreate(
    \App\Http\Controllers\PriceController::class,
    'price',
    'price',
    config('app.adminUrl'),
    'admin'
);
crudRouteCreate(
    \App\Http\Controllers\ProductController::class,
    'product',
    'product',
    config('app.adminUrl'),
    'admin'
);
crudRouteCreate(
    \App\Http\Controllers\SeoController::class,
    'seo',
    'seo',
    config('app.adminUrl'),
    'admin'
);
crudRouteCreate(
    \App\Http\Controllers\CategoryController::class,
    'category',
    'category',
    config('app.adminUrl'),
    'admin'
);

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

//Auth::routes();
