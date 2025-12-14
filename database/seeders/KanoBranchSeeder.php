<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Business;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class KanoBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Try to reuse existing demo business if present
        $business = Business::firstOrCreate(
            ['slug' => 'cutietyha-demo'],
            [
                'name' => 'Cutietyha Demo',
                'address' => 'Kano, Nigeria',
                'email' => 'info@cutietyha.ng',
                'phone' => '+234 800 000 0000',
                'subscription_status' => 'active',
            ]
        );

        // Create or get the Kano branch
        $branch = Branch::firstOrCreate(
            ['business_id' => $business->id, 'name' => 'Kano Branch'],
            [
                'location' => 'Kano, Nigeria',
                'geo_lat' => 11.9668,
                'geo_lng' => 8.4892,
            ]
        );

        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $salesRole = Role::firstOrCreate(['name' => 'sales']);

        // Admin user for Kano Branch
        $admin = User::updateOrCreate(
            ['email' => 'admin@cutietyha.ng'],
            [
                'name' => 'Kano Admin',
                'display_name' => 'Kano Admin',
                'password' => Hash::make('qTLh2rAEW!{8CeEA'),
                'phone' => '+234 800 000 0100',
                'branch_id' => $branch->id,
            ]
        );
        $admin->assignRole($adminRole);

        // Sales user one
        $salesOne = User::updateOrCreate(
            ['email' => 'salesone@cutietyha.ng'],
            [
                'name' => 'Sales One (Kano)',
                'display_name' => 'Sales One',
                'password' => Hash::make('YnP*3cgi7}Ye7)i8'),
                'phone' => '+234 800 000 0101',
                'branch_id' => $branch->id,
            ]
        );
        $salesOne->assignRole($salesRole);

        // Sales user two
        $salesTwo = User::updateOrCreate(
            ['email' => 'salestwo@cutiehya.ng'],
            [
                'name' => 'Sales Two (Kano)',
                'display_name' => 'Sales Two',
                'password' => Hash::make('gP&5_f;6mzB_g1,h'),
                'phone' => '+234 800 000 0102',
                'branch_id' => $branch->id,
            ]
        );
        $salesTwo->assignRole($salesRole);
    }
}
