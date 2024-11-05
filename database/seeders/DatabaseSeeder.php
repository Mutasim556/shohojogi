<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\User;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

            // $admin = new Admin();
            // $admin->name = 'Mutasim';
            // $admin->email = 'admin@admin.com';
            // $admin->phone = '01724698392';
            // $admin->username = 'mutasim';
            // $admin->password = Hash::make('admin');
            // $admin->assignRole('Super Admin');
            // $admin->save();

        $this->call(PermissionSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(AdminSeeder::class);
    }
}
