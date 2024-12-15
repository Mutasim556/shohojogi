<?php
return [
    'name'=>'Doctor',
    'permissions'=>"'doctor-speciality-index','doctor-speciality-create','doctor-speciality-update','doctor-speciality-delete'",
    'sub_menu'=>[
        'name'=>'Doctor Specility',
        'route'=>route('doctor.speciality.index'),
        'permissions' => "'doctor-speciality-index','doctor-speciality-create','doctor-speciality-update','doctor-speciality-delete'"
    ],
    'route'=>''
];