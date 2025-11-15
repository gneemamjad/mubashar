<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;

Route::get('/adCat/{category?}', [AdController::class, 'home'])->name('landing');
