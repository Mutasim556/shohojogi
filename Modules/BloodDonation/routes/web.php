<?php

use Illuminate\Support\Facades\Route;
use Modules\BloodDonation\app\Http\Controllers\BloodDonorController;

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

Route::group([
    'prefix'=>'blood-donation',
    'as'=>'blood_donation.',
    'middleware'=>'web',
], function () {
    Route::resource('/donor',BloodDonorController::class);
    Route::group(['prefix'=>'donor'],function(){
        Route::get('/get/division-information/{type}/{id}',function(){
            $result = request()->type=='district'?get_district(request()->id):get_upazila(request()->id);
            return response()->json($result);
        });
        Route::get('/status/update',[BloodDonorController::class,'changeStatus']);
    });
});
