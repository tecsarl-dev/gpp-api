<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/users', ['App\Http\Controllers\UserController','store']);
Route::put('/users/{users}', ['App\Http\Controllers\UserController','update'])->middleware('auth:api');
Route::post('/login', ['App\Http\Controllers\UserController','login']);
Route::post('/register', ['App\Http\Controllers\UserController','register']);
Route::post('/me', ['App\Http\Controllers\UserController','me'])->middleware('auth:api');
Route::get('/logout', ['App\Http\Controllers\UserController','logout'])->middleware('auth:api');
Route::post('/verifyEmail', ['App\Http\Controllers\UserController','verifyEmail']);
Route::post('/getNewCode', ['App\Http\Controllers\UserController','getNewCode']);

Route::resource('/companies', 'App\Http\Controllers\CompanyController')->middleware('auth:api');
Route::resource('/decisions', 'App\Http\Controllers\DecisionController')->middleware('auth:api');
Route::resource('/cities', 'App\Http\Controllers\CityController')->middleware('auth:api');
Route::resource('/stations', 'App\Http\Controllers\StationController')->middleware('auth:api');
Route::resource('/loading_slips', 'App\Http\Controllers\LoadingSlipController')->middleware('auth:api');
Route::resource('/deliveries', 'App\Http\Controllers\DeliveryController')->middleware('auth:api');
Route::resource('/rates', 'App\Http\Controllers\RateController')->middleware('auth:api');
Route::resource('/products', 'App\Http\Controllers\ProductController')->middleware('auth:api');
Route::resource('/depots', 'App\Http\Controllers\DepotController')->middleware('auth:api');
Route::resource('/capacities', 'App\Http\Controllers\CapacityController')->middleware('auth:api');
Route::resource('/responsibles', 'App\Http\Controllers\ResponsibleController')->middleware('auth:api');
Route::resource('/trucks', 'App\Http\Controllers\TruckController')->middleware('auth:api');
Route::resource('/product_lists', 'App\Http\Controllers\ProductListController')->middleware('auth:api');

Route::get('/lists/products', ['App\Http\Controllers\ProductController','listProducts'])->middleware('auth:api');
Route::get('/lists/depots', ['App\Http\Controllers\DepotController','listDepots'])->middleware('auth:api');
Route::get('/lists/trucks', ['App\Http\Controllers\TruckController','listTrucks'])->middleware('auth:api');
Route::get('/lists/stations', ['App\Http\Controllers\StationController','listStations'])->middleware('auth:api');
Route::get('/lists/transporters', ['App\Http\Controllers\CompanyController','listTransporters'])->middleware('auth:api');
Route::get('/lists/companies', ['App\Http\Controllers\CompanyController','index'])->middleware('auth:api');

Route::post('/companies/decisions/{id}',['App\Http\Controllers\CompanyController','decision'])->middleware('auth:api');
Route::post('/stations/decisions/{id}',['App\Http\Controllers\StationController','decision'])->middleware('auth:api');
Route::post('/trucks/decisions/{id}',['App\Http\Controllers\TruckController','decision'])->middleware('auth:api');

Route::get('/files/companies/{files}', ['App\Http\Controllers\CompanyController', 'download'])->middleware('auth:api');
Route::get('/files/stations/{files}', ['App\Http\Controllers\StationController', 'download'])->middleware('auth:api');
Route::get('/files/trucks/{files}', ['App\Http\Controllers\TruckController', 'download'])->middleware('auth:api');
