<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Business & Branch Management
            'manage businesses',
            'view businesses',
            'create businesses',
            'update businesses',
            'delete businesses',
            'manage branches',
            'view branches',
            'create branches',
            'update branches',
            'delete branches',

            // Product Management
            'manage products',
            'view products',
            'create products',
            'update products',
            'delete products',
            'manage inventory',
            'view inventory',

            // POS & Orders
            'use pos',
            'view orders',
            'create orders',
            'update orders',
            'delete orders',
            'approve orders',

            // Payments
            'view payments',
            'create payments',
            'process payments',

            // Expenses
            'view expenses',
            'create expenses',
            'update expenses',
            'delete expenses',

            // Shifts & Attendance
            'clock in',
            'clock out',
            'view shifts',
            'manage shifts',

            // Reports & Exports
            'view reports',
            'export reports',
            'view accounting',

            // Users & Staff
            'manage users',
            'view users',
            'create users',
            'update users',
            'delete users',

            // Settings
            'manage settings',
            'view settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'manage branches',
            'view branches',
            'create branches',
            'update branches',
            'delete branches',
            'manage products',
            'view products',
            'create products',
            'update products',
            'delete products',
            'manage inventory',
            'view inventory',
            'view orders',
            'create orders',
            'update orders',
            'approve orders',
            'view payments',
            'create payments',
            'process payments',
            'view expenses',
            'create expenses',
            'update expenses',
            'delete expenses',
            'view shifts',
            'manage shifts',
            'view reports',
            'export reports',
            'view accounting',
            'manage users',
            'view users',
            'create users',
            'update users',
            'manage settings',
            'view settings',
        ]);

        $sales = Role::firstOrCreate(['name' => 'sales']);
        $sales->givePermissionTo([
            'use pos',
            'view products',
            'view inventory',
            'create orders',
            'view orders',
            'create payments',
            'clock in',
            'clock out',
            'view shifts',
        ]);

        $accounting = Role::firstOrCreate(['name' => 'accounting']);
        $accounting->givePermissionTo([
            'view orders',
            'view payments',
            'view expenses',
            'view reports',
            'export reports',
            'view accounting',
        ]);
    }
}

