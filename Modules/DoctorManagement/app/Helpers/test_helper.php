<?php

function dm_module_config(){
    return [
        'name'=>__('admin_local.Doctor'),
        'permissions'=>"'doctor-speciality-index','doctor-speciality-create','doctor-speciality-update','doctor-speciality-delete'",
        'sub_menu'=>[
           [
            'name'=>__('admin_local.Doctor Specility'),
            'route'=>route('doctor.speciality.index'),
            'permissions' => "'doctor-speciality-index','doctor-speciality-create','doctor-speciality-update','doctor-speciality-delete'",
            'submenu'=>false
           ],
           
        ],
        'route'=>'',
        'valid'=>true,
        'submenu'=>true
    ];
}
