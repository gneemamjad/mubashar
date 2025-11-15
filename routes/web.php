<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Front\AdController;
use App\Http\Controllers\FrontEndController;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(auth()->guard('admin')->check()){
        return view('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

Route::middleware(['auth'])->group(function () {
    // ... existing routes ...

});

// Route::get('/payment/success', function() {
//     return view('payment.success');
// })->name('payment.success');

// Route::get('/payment/cancel', function() {
//     return view('payment.cancel');
// })->name('payment.cancel');

Route::get('locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('locale');

Route::view('privacy', 'privacy');

Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/ad/{id}', [FrontEndController::class, 'showAdd']);

Route::get('importcsvexcel', function () {
    // $path = storage_path('app/public/categories.csv');
    // if (!file_exists($path)) {
    //     abort(404, "File not found at $path");
    // }
    // $rows = array_map('str_getcsv', file($path));
    // $header = array_map('trim', $rows[0] ?? []);
    // unset($rows[0]);

    // foreach ($rows as $row) {
    //     // $data = array_combine($header, $row);
    //     // if (!$data) continue;

    //     DB::table('category')
    //         ->where('id', $row[0])
    //         ->update([
    //             'name' => json_encode([
    //                 'en' => $row[1],
    //                 'ar' => $row[2],
    //             ])
    //         ]);
    // }

    // return response()->json(['message' => 'Import completed']);
});


Route::get('ads/{ad_number}', [AdController::class, 'show'])->name('showAd');
Route::get('/adCat/{category?}', [AdController::class, 'home'])->name('landing');
Route::get('/load-ads', [AdController::class, 'loadMoreAds'])->name('ads.load');
