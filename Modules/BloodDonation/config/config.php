<?php

return [
    'name' => __('admin_local.Blood Donation'),
    'permissions' => ['blood-donor-index','blood-donor-create','blood-donor-update','blood-donor-delete'],
    'sub_menu' => [
        [
            'name' => __('admin_local.Blood Donor'),
            'route' => route('blood_donation.donor.index'),
            'permissions' => ['blood-donor-index','blood-donor-create','blood-donor-update','blood-donor-delete'],
            'submenu' => false
        ],
    ],
    'route' => '',
    'valid' => true,
    'submenu' => true
];
