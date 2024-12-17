<?php

use App\Models\Admin\Language;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

function userRoleName(){
    return auth()->guard('admin')->user()->getRoleNames()->first();
}


function hasPermission(array $permission){
    if(userRoleName()==='Super Admin'){
        return true;
    }else{
        return auth()->guard('admin')->user()->hasAnyPermission($permission);
    }
}


function generateRandomString(){
    $key = random_int(0, 999999);
    $key = str_pad($key, 6, 0, STR_PAD_LEFT);
    return $key;
}

function LoggedAdmin(){
    return Auth::guard('admin')->user();
}

function setLanguage(string $lang) : void{
    Cookie::queue('language', $lang, 10);
    // session(['language'=>$code]);
}
function getLanguageSession() : string {
    if(Cookie::get('language') !== null){
        return Cookie::get('language');
    }else{
        try {
            $language = Language::where('default',1)->first();
            setLanguage($language->lang);
            return $language->lang;
        } catch (\Throwable $th) {
            setLanguage('en');
            return Cookie::get('language');
        }
    }
}

function routeExist(string $routeName){

}

//turn of/on maintenance mail
function maintenanceMailSwitch(){
    return false;
} 


function get_division(){
    return DB::table('divisions')->where([['status',1]])->select('id','name','bn_name')->get();
}

function get_district($id){
    return DB::table('districts')->where([['status',1],['division_id',$id]])->select('id','name','bn_name')->get();
}

function get_upazila($id){
    return DB::table('upazilas')->where([['status',1],['district_id',$id]])->select('id','name','bn_name')->get();
}