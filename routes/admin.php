<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Api\AdController as APIAdController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReelController;
use App\Http\Controllers\Api\ReelController as APIReelController;
use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group.
|
*/

// Admin API Routes
// Route::middleware('web')->group(function () {
Route::group(['middleware' => ['auth:admin','tra'], 'as' => 'admin.'], function () {

    Route::get('/play-reports', [App\Http\Controllers\Admin\PlayReportController::class, 'index'])->name('play.reports');
    Route::get('/play-reports/fetch', [App\Http\Controllers\Admin\PlayReportController::class, 'fetch']);


     // Cities routes
     Route::post('/cities', [CityController::class, 'store'])->name('cities.store');

     // Areas routes
     Route::resource('areas', AreaController::class);
     Route::get('areas/get', [AreaController::class, 'getAreas'])->name('areas.get');
     Route::put('areas/{area}/status', [AreaController::class, 'updateStatus'])->name('areas.status');

     // Cities
     Route::resource('cities', CityController::class);
     Route::post('cities/{city}/delete', [CityController::class, 'destroy'])->name('cities.delete');
     Route::post('cities/{id}/update', [CityController::class, 'update'])->name('cities.uppdate');
     Route::post('cities/{city}/toggle-status', [CityController::class, 'toggleStatus'])->name('cities.toggle-status');
     Route::get('cities-data', [CityController::class, 'data'])->name('cities.data');

     // Areas
     Route::resource('areas', AreaController::class);
     Route::post('areas/{area}/delete', [AreaController::class, 'destroy'])->name('areass.delete');
     Route::post('areas/{id}/update', [AreaController::class, 'update'])->name('areass.uppdate');
     Route::post('areas/{area}/toggle-status', [AreaController::class, 'toggleStatus'])->name('areas.toggle-status');
     Route::get('areas-data', [AreaController::class, 'data'])->name('areas.data');


    Route::get('users/{user}/ads', [UserController::class, 'userAds'])->name('admin.users.ads');

    Route::post('users/store', [UserController::class, 'store'])->name('users.store');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/search-users', [UserController::class, 'searchAjax']);
    Route::get('/search-ads', [AdController::class, 'searchAjax']);
    Route::get('/search-categories', [CategoryController::class, 'searchAjax']);

    // Existing routes...
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::resource('notifications', NotificationController::class)->except(['show', 'edit', 'update']);
    // Route::resource('categories', CategoryController::class);

    Route::get('notifications/data', [NotificationController::class, 'data'])->name('notifications.data');

    Route::get('get-areas-by-city/{city_id}', [GeneralController::class, 'getAreasByCity'])->name('getAreasByCity');
    // Add new Ads Management Routes
    Route::group(['prefix' => 'ads', 'as' => 'ads.'], function () {
        Route::get('/', [AdController::class, 'index'])->name('index');
        Route::get('/create', [AdController::class, 'create'])->name('createAd');
        Route::post('/store', [AdController::class, 'store'])->name('storeAd');
        Route::get('/edit/{id}', [AdController::class, 'edit'])->name('editAd');
        Route::post('/{id}/update', [AdController::class, 'update'])->name('updateAd');
        Route::get('/get-ad-images/{id}', [AdController::class, 'getAdImages'])->name('getAdImages');
        Route::delete('/images/{id}', [AdController::class, 'deleteImage']);
        Route::post('add-images',[APIAdController::class,'addAdImagesFromAdmin'])->name('addAdImagesFromAdmin');
        Route::get('/pending', [AdController::class, 'pending'])->name('pending');
        Route::post('/data', [AdController::class, 'data'])->name('data');
        Route::post('/data-pending', [AdController::class, 'dataPending'])->name('data-pending');
        Route::get('/nearby/{ad}', [AdController::class, 'nearbyAds'])->name('nearby');
        Route::get('/reviews', [AdController::class, 'reviews'])->name('reviews');
        Route::get('/reviews/data', [AdController::class, 'reviewsData'])->name('reviews.data');
        Route::get('/{ad}', [AdController::class, 'show'])->name('show');
        Route::post('/{ad}/toggle-status', [AdController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{ad}/change-status', [AdController::class, 'changeStatus'])->name('change-status');
        Route::post('/{ad}/toggle-active', [AdController::class, 'toggleActive'])->name('toggle-active');
        Route::post('/{ad}/toggle-premium', [AdController::class, 'togglepremium'])->name('toggle-premium');
        Route::post('/{ad}/toggle-sold', [AdController::class, 'togglesold'])->name('toggle-sold');
        Route::post('/{ad}/toggle-rented', [AdController::class, 'togglerented'])->name('toggle-rented');
        Route::post('/{ad}/toggle-highlighter', [AdController::class, 'togglehighlighter'])->name('toggle-highlighter');
        Route::delete('/{ad}', [AdController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/update-status', [AdController::class, 'updateStatus'])->name('update-status');

    });


    Route::group(['prefix' => 'reels', 'as' => 'reels.'], function () {
        Route::post('/store', [ReelController::class, 'store'])->name('storeReel');
        Route::post('add-reel',[APIReelController::class,'addReelFromAdmin'])->name('addReelFromAdmin');
        Route::get('/', [ReelController::class, 'index'])->name('index');
        Route::get('/pending', [ReelController::class, 'pending'])->name('pending');
        Route::post('/data', [ReelController::class, 'data'])->name('data');
        Route::post('/data-pending', [ReelController::class, 'dataPending'])->name('data-pending');
        Route::get('/{id}/change-status', [ReelController::class, 'changeStatus'])->name('change-status');
        Route::get('/{id}/delete', [ReelController::class, 'delete'])->name('delete');
        Route::get('/create', [ReelController::class, 'create'])->name('createReel');
    });
    // Add new Ads Management Routes
    Route::group(['prefix' => 'currencies', 'as' => 'currencies.'], function () {
        Route::get('/', [CurrencyController::class, 'index'])->name('index');

        Route::post('/update-rate', [CurrencyController::class, 'updateRate'])
            ->name('admin.currencies.update-rate');
    });
});

Route::group(['middleware' => ['auth:admin','tra','tra']], function () {

    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/users-reports', [ReportController::class, 'userReports'])->name('usersReport');
        Route::get('/ads-reports', [ReportController::class, 'adsReports'])->name('adsReport');
        Route::get('/finicial-reports', [ReportController::class, 'finicialReports'])->name('finicialReport');
        Route::get('/users-export', [ReportController::class, 'usersReport'])->name('users.export');
        Route::get('/ads-export', [ReportController::class, 'adsReport'])->name('ads.export');
        Route::get('/transactions-export', [ReportController::class, 'transactionsReport'])->name('transactions.export');

    });

    Route::get('/reports/users', [ReportController::class, 'usersReport'])->name('reports.users');
    Route::get('/reports/ads', [ReportController::class, 'adsReport'])->name('reports.ads');

    // Admin Management Routes
    Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::post('/delete/{admin}', [AdminController::class, 'destroy'])->name('destroyss');
        Route::post('/data', [AdminController::class, 'data'])->name('data');
    });
});

Route::group(['middleware' => ['auth:admin','tra','tra']], function () {
    // Admin Management Routes
    Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
        Route::post('/data', [AdminController::class, 'data'])->name('data');
    });



    Route::group(['middleware' => ['auth:admin','tra'], 'prefix' => 'categories', 'as' => 'admin.categories.'], function () {

        Route::get('/tree', [CategoryController::class, 'tree'])->name('tree');
        Route::get('/cat-tree', [CategoryController::class, 'catTree'])->name('catTree');
        Route::get('/search-cat-tree', [CategoryController::class, 'searchCatTree'])->name('searchCatTree');
        // Route::post('{category}', [CategoryController::class, 'update'])->name('update');
        Route::get('{category}/attributes', [CategoryController::class, 'getAttributes']);
        Route::post('{category}/attributes', [CategoryController::class, 'updateAttributes']);
        Route::post('{category}/move', [CategoryController::class, 'moveCategory'])->name('move');
        Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->name('destroy_category');
        Route::post('/{id}/update',[CategoryController::class, 'updateCategory']);
        Route::resource('/', CategoryController::class);
        Route::post('{id}/clone', [CategoryController::class, 'clone'])->name('clone');
    });
    Route::post('/admins/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admins.toggle-status');
    // User Management Routes
    Route::group(['middleware' => ['auth:admin','tra'], 'prefix' => 'users', 'as' => 'admin.users.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/data', [UserController::class, 'getData'])->name('data');
        Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/{id}', [UserController::class, 'update'])->name('update');
        Route::post('/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('toggle-block');
        Route::post('users/data', [UserController::class, 'data'])->name('users.data');
        Route::get('users/search', [UserController::class, 'search'])->name('search');
    });
});

Route::get('login', [AuthController::class, 'getLogin'])->name('admin.login.form');
Route::get('dashboard', function () {
    if(auth()->guard('admin')->check()){
        return view('admin.dashboard');
    }
    return view('admin.login');
})->name('admin.dashboard')->middleware('auth:admin','tra');

Route::get('/', function () {
    if(auth()->guard('admin')->check()){
        return view('admin.dashboard');
    }
    return view('admin.login');
})->name('admin.home')->middleware('auth:admin','tra');


Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::post('register', [AuthController::class, 'register'])->name('admin.register');

// Protected Admin Routes
Route::middleware('auth:admin','tra')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    // Route::get('profile', [AuthController::class, 'profile'])->name('admin.profile');
});

Route::get('attributes/list', [AttributeController::class, 'list'])->name('admin.attributes.list');

Route::get('attributes/available/{category}', [AttributeController::class, 'available'])->name('admin.attributes.available');
Route::delete('categories/{category}/attributes/{attribute}', [CategoryController::class, 'removeAttribute']);
Route::post('categories/{category}/attributes/{attribute}/toggle-filter', [CategoryController::class, 'toggleAttributeFilter']);

Route::group(['middleware' => ['auth:admin','tra'], 'prefix' => 'attributes', 'as' => 'admin.attributes.'], function () {
    Route::get('/', [AttributeController::class, 'index'])->name('index');
    Route::get('/create', [AttributeController::class, 'create'])->name('create');
    Route::post('/', [AttributeController::class, 'store'])->name('store');
    Route::get('/{attribute}/edit', [AttributeController::class, 'edit'])->name('edit');
    Route::put('/{attribute}', [AttributeController::class, 'update'])->name('update');
    Route::delete('/{attribute}', [AttributeController::class, 'destroy'])->name('destroy');
    Route::post('/data', [AttributeController::class, 'data'])->name('data');
});

// Plans Routes
Route::group(['middleware' => ['auth:admin','tra']], function () {
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::get('/plans/list', [PlanController::class, 'getPlans'])->name('plans.list');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
});

Route::get('/dashboard/payment-stats', [DashboardController::class, 'getPaymentStats'])
    ->name('admin.dashboard.payment-stats')
    ->middleware('auth:admin');

Route::get('/reports/ad-charts', [ReportController::class, 'adCharts'])->name('reports.adCharts')->middleware(['auth:admin','tra']);
Route::get('/reports/ad-charts/data', [ReportController::class, 'getAdChartsData'])->name('reports.adCharts.data')->middleware(['auth:admin','tra']);
Route::get('/reports/ad-charts/data-approved', [ReportController::class, 'getAdChartsDataApproved'])->name('reports.adCharts.approved')->middleware(['auth:admin','tra']);
Route::get('/reports/ad-charts/category-data', [ReportController::class, 'getCategoryChartData'])
    ->name('reports.adCharts.categoryData')
    ->middleware(['auth:admin','tra']);

Route::get('/ads/reviews/data', [AdController::class, 'reviewsData'])->name('ads.reviews.data');
