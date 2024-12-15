<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Modules\DoctorManagement\app\Http\Controllers\DoctorSpecialityController;
use Modules\DoctorManagement\Http\Controllers\DoctorManagementController;

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
    'prefix'=>'doctor',
    'as' => 'doctor.',
    'middleware'=>'web'
], function () {
    Route::resource('speciality',DoctorSpecialityController::class);
    Route::get('/test',function(){
        dd(dm_module_config()['name']);

        // $command = shell_exec('composer dump-autoload');

        // if($command){
        //     echo 'success';
        // }else{
        //     echo 'failed';
        // }
    });
});
