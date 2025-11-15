<?php

use App\Models\Category;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\API\HomePageController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FiltersController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\GeneralController;
use App\Http\Resources\API\AdDetailsResource;
use App\Http\Resources\API\UserResource;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\NotificationsController;
use App\Http\Controllers\EpaymentController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\StripeWebhookController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\ReelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/





// Test API Route

// Route::get('/test', function () {

//     // $root = Category::create(['name' => 'Root category', 'type' => 1]);
//     // $root->setTranslation('name', 'ar', 'عربي');
//     // $root->save();
//     // $firstRootNode = Category::root();

//     // $child2 = Category::create(['name' => 'Child 3','type' => 1]);
//     // $child2->makeChildOf($firstRootNode);


//     $child2 = Category::find(4);
//     // $child3 = Category::create(['name' => 'Child 4','type' => 1]);
//     // $child3->makeChildOf($child2);

//     return response()->json($child2->getDescendantsAndSelf()->pluck('id'));
// });

// Route::get('/test-attr',function(){
//     $ad = Ad::with('attributes')->first();
//     return json_encode(new AdDetailsResource($ad));
// })->middleware('localization');


Route::prefix('paymants')->group(function () {
    Route::get('/success', [EpaymentController::class, 'successPayment'])->name('payment.success');
    Route::post('/webhook-success', [EpaymentController::class, 'webhookSuccess'])->name('webhook.success');

});

Route::group(['middleware' => ['auth:api','appVersion','blocker']], function () {


    Route::get('currencies', [GeneralController::class, 'getCurrencies']);

    Route::get('notifications-history', [NotificationsController::class, 'getNotificationHistory']);


    Route::post('/update-fcm-token', [AuthenticationController::class, 'updateFcmToken']);


    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::resource('ads',AdController::class);
    Route::post('ads/create',[AdController::class,'createP']);
    Route::delete('ads/{ad_id}',[AdController::class,'destroy']);
    Route::get('ads-bulk',[AdController::class,'bulkAds']);
    Route::post('ads/add-featured-attributes',[AdController::class,'addFeaturedAttributes']);

    Route::get('reels',[ReelController::class,'index']);
    Route::get('reels/{user_id}',[ReelController::class,'indexByUser']);
    Route::put('reels/{id}',[ReelController::class,'updateLike']);
    Route::post('reels',[ReelController::class,'create']);
    
    Route::get('/change-lang/{lang}',[GeneralController::class,'changeLanguage']);
    Route::get('/price-history/{ad_id}',[AdController::class,'getPricingHistory']);

    //Favorites
    Route::get('/favorites',[AdController::class,'getFavoratesList']);
    Route::get('/home-favorites',[AdController::class,'getHomeFavoratesList']);
    Route::post('/add-to-favorites',[AdController::class,'addToFavorites']);
    Route::post('/remove-from-favorites',[AdController::class,'removeFromFavorites']);

    //Review
    Route::prefix('review')->group(function () {
        Route::get('/options',[ReviewController::class,'getOptions']);
        Route::post('/store',[ReviewController::class,'store']);
    });
    //Review
    Route::prefix('owner-review')->group(function () {
        Route::post('/store',[ReviewController::class,'storeOwnerReview']);
    });


    Route::get('/last-seen-ads', [AdController::class, 'getLastSeenAdsByMe']);
    Route::group(['prefix' => 'categories'],function(){
        Route::get('/main',[CategoryController::class,'getMainCategories']);
        Route::get('/sub/{category}',[CategoryController::class,'getSubCategories']);
    });

    //send sms
    Route::post('sms', [AdController::class, 'sendSms'])->name('sendSms');
    //filterd by category
    Route::get('filters', [FiltersController::class, 'getFilterByCategory'])->name('getFilterByCategory');

    //Profile
    Route::get('profile-main-info', [ProfileController::class, 'getMainInfo'])->name('getMainInfo');
    Route::get('my-ads', [AdController::class, 'getMyAds'])->name('getMyAds');
    Route::get('my-reels', [ReelController::class, 'getMyReels'])->name('getMyReels');
    Route::post('update-profile', [ProfileController::class, 'update'])->name('updateProfile');
    Route::get('my-account',[ProfileController::class,'myAccount'])->name('myAccount');
    Route::delete('delete-account', [ProfileController::class, 'deleteAccount'])->name('deleteAccount');
    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::prefix('ad')->group(function(){
        Route::get('my-drafts',[AdController::class,'getMyDraftAds'])->name('getMyDraftAds');
        Route::get('last-draft',[AdController::class,'getLastDraftAd'])->name('getLastDraftAd');
        Route::post('add-location',[AdController::class,'addAdLocation'])->name('addAdLocation');
        Route::post('add-images',[AdController::class,'addAdImages'])->name('addAdImages');
        Route::post('update-images',[AdController::class,'updateAdImages'])->name('updateAdImages');
        Route::post('/update-book/{ad}',[AdController::class,'updateBook'])->name('updateAdBook');
    });


    //cities and ares
    Route::get('cities', [GeneralController::class, 'getCities'])->name('getCities');
    Route::get('areas', [GeneralController::class, 'getAreas'])->name('getAreas');
    Route::get('get-areas-by-city/{city_id}', [GeneralController::class, 'getAreasByCity'])->name('getAreasByCity');
    Route::post('ads/select-plan', [AdController::class, 'selectPlan']);
    Route::get('/attributes-with-selected/{ad}',[AdController::class,'getStaticAttributesWithSelected']);
    Route::post('/update-attributes',[AdController::class,'updateAttributes']);

    Route::post('ads/personal-info', [AdController::class, 'updateAdPersonalInfo']);
    
    Route::get('/nearby-ads',[AdController::class,'getNearByAds']);
    Route::get('/most-viewed-ads', [AdController::class, 'getMostViewedAds']);
    Route::get('/premium-ads-auth',[AdController::class,'getPremiumAds']);
    
    Route::get('/showcase-ads',[AdController::class,'getShowcaseAds']);
});

Route::get('/home-sections',[GeneralController::class,'getHomeSections']);
Route::get('/suggested-ads',[AdController::class,'getSuggestedAds']);
Route::get('/premium-ads',[AdController::class,'getPremiumAds']);
Route::get('/static-attributes/{category}',[AdController::class,'getStaticAttributes']);

Route::get('/featured-attributes/{category}',[AdController::class,'getFeaturedAttributes']);

Route::group(['middleware' => ['appVersion']], function () {

    //Authentication Routes
    Route::post('register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('verify', [AuthenticationController::class, 'verify'])->name('verify');
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');


    Route::get('plans', [PlanController::class, 'index']);
    Route::get('plans/{plan}', [PlanController::class, 'show']);

    //app_details route
    Route::get('/app-details/{key}', [GeneralController::class,'getAppDetails']);
});

Route::get('/clear-cache', [GeneralController::class, 'clearCache']);

// Country routes
Route::get('countries', [CountryController::class, 'index']);
Route::get('countries/code/{code}', [CountryController::class, 'getByCode']);
Route::get('countries/dial-code/{dialCode}', [CountryController::class, 'getByDialCode']);
Route::get('test-sms', [AdController::class, 'testSendSms']);
// Banks List
Route::get('/banks', [BankController::class, 'index']);
Route::middleware('auth:api')->group(function () {

    Route::get('/get-currencies-by-bank/{bankId}',[PaymentController::class,'getCurrenciesByBank']);

    Route::post('/payment/create-intent', [PaymentController::class, 'createPaymentIntent']);
    Route::post('/payment/confirm', [PaymentController::class, 'confirmPayment']);
    Route::get('/payment/status', [PaymentController::class, 'checkPaymentStatus']);
    Route::post('/payment/create-checkout', [PaymentController::class, 'createCheckout']);

});
Route::get('/payment/success', [PaymentController::class, 'success'])->name('api.payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('api.payment.cancel');

// Stripe webhook
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])->name('stripe.webhook');

// Stripe refund endpoint
Route::post('/stripe/refund', [StripeWebhookController::class, 'refund'])
    ->middleware('auth:api')
    ->name('stripe.refund');

// Add this with your other API routes
Route::get('/settings', [SettingsController::class, 'getSettings'])
->middleware('auth.optional:api');


Route::get('latest-users', [SettingsController::class, 'getLatestUsers']);




