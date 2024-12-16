<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creating permission for users
        // Permission::create(['guard_name'=>'admin','name'=>'user-index','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-create','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-update','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-delete','group_name'=>'User Permissions']);

        //permission for role
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-index','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-create','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-update','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-delete','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'specific-permission-create','group_name'=>'Roles And Permissions']);

        //permission for language
        // Permission::create(['guard_name'=>'admin','name'=>'language-index','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-create','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-update','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-delete','group_name'=>'Language Permissions']);

        //backend language permission
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-generate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-translate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-update','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-index','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-api-accesskey','group_name'=>'Backend Language Permissions']);


        //creating permission for doctor
        // Permission::create(['guard_name'=>'admin','name'=>'doctor-speciality-index','group_name'=>'Doctor Speciality']);
        // Permission::create(['guard_name'=>'admin','name'=>'doctor-speciality-create','group_name'=>'Doctor Speciality']);
        // Permission::create(['guard_name'=>'admin','name'=>'doctor-speciality-update','group_name'=>'Doctor Speciality']);
        // Permission::create(['guard_name'=>'admin','name'=>'doctor-speciality-delete','group_name'=>'Doctor Speciality']);

        //creating permission for Blood Donation
        // Permission::create(['guard_name'=>'admin','name'=>'blood-donor-index','group_name'=>'Blood Donor']);
        // Permission::create(['guard_name'=>'admin','name'=>'blood-donor-create','group_name'=>'Blood Donor']);
        // Permission::create(['guard_name'=>'admin','name'=>'blood-donor-update','group_name'=>'Blood Donor']);
        // Permission::create(['guard_name'=>'admin','name'=>'blood-donor-delete','group_name'=>'Blood Donor']);

    }
}
