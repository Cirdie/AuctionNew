<?php

use App\Http\Controllers\Api\CategoryController as ApiCategoryController;
use App\Http\Controllers\Api\CountryController as ApiCountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CountryController;

Route::get('/subcategories/{slug}', [ApiCategoryController::class, 'getSubCategories'])
    ->name('categories.sub-categories');

Route::get('/states/{iso2code}', [ApiCountryController::class, 'getStates'])
    ->name('countries.states');

Route::get('/cities/{iso2code}/{stateCode}', [ApiCountryController::class, 'getCities'])
    ->name('countries.cities');

    Route::get('/states/{iso2code}', [CountryController::class, 'getStates']);
Route::get('/cities/{iso2code}/{stateCode}', [CountryController::class, 'getCities']);
Route::get('/barangays/{cityCode}', [CountryController::class, 'getBarangays']);
