<?php

namespace Modules\BloodDonation\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class BloodDonationPermissionSeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creating permission for Blood Donation
        // Permission::create(['guard_name'=>'admin','name'=>'blood-donor-index','group_name'=>'Blood Donor']);
        // Permission::create(['guard_name'=>'admin','name'=>'blood-donor-create','group_name'=>'Blood Donor']);
        // Permission::create(['guard_name'=>'admin','name'=>'blood-donor-update','group_name'=>'Blood Donor']);
        // Permission::create(['guard_name'=>'admin','name'=>'blood-donor-delete','group_name'=>'Blood Donor']);
        // Permission::create(['guard_name'=>'admin','name'=>'blood-donor-all-view','group_name'=>'Blood Donor']);
        // dd('dsfdsf');
    }
}
