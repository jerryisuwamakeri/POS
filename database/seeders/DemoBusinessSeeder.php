<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Branch;
use App\Models\User;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DemoBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo business (or get existing)
        $business = Business::firstOrCreate(
            ['slug' => 'cutietyha-demo'],
            [
                'name' => 'Cutietyha Demo',
                'address' => '123 Main Street, Kaduna, Nigeria',
                'email' => 'demo@cutietyha.com',
                'phone' => '+234 800 000 0000',
                'subscription_status' => 'active',
            ]
        );

        // Create branch (or get existing)
        $branch = Branch::firstOrCreate(
            ['business_id' => $business->id, 'name' => 'Kaduna HQ'],
            [
                'location' => '123 Main Street, Kaduna',
                'geo_lat' => 10.5105,
                'geo_lng' => 7.4165,
            ]
        );

        // Get roles
        $superAdminRole = Role::findByName('super_admin');
        $adminRole = Role::findByName('admin');
        $salesRole = Role::findByName('sales');
        $accountingRole = Role::findByName('accounting');

        // Create users (or get existing) and update passwords
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@cutietyha.ng'],
            [
            'name' => 'Super Admin',
            'display_name' => 'Super Admin',
            'email' => 'superadmin@cutietyha.ng',
            'password' => Hash::make('+Lxg~A(nMR!LIx}]'),
            'phone' => '+234 800 000 0001',
            'role' => 'super_admin',
            'branch_id' => null,
        ]);
        $superAdmin->password = Hash::make('+Lxg~A(nMR!LIx}]');
        $superAdmin->save();
        $superAdmin->assignRole($superAdminRole);

        $admin = User::firstOrCreate(
            ['email' => 'admin@cutietyha.ng'],
            [
                'name' => 'Admin User',
                'display_name' => 'Admin',
                'email' => 'admin@cutietyha.ng',
                'password' => Hash::make('qTLh2rAEW!{8CeEA'),
                'phone' => '+234 800 000 0002',
                'role' => 'admin',
                'branch_id' => $branch->id,
            ]
        );
        $admin->password = Hash::make('qTLh2rAEW!{8CeEA');
        $admin->save();
        $admin->assignRole($adminRole);

        $salesOne = User::firstOrCreate(
            ['email' => 'salesone@cutietyha.ng'],
            [
                'name' => 'Sales Person One',
                'display_name' => 'Sales One',
                'email' => 'salesone@cutietyha.ng',
                'password' => Hash::make('YnP*3cgi7}Ye7)i8'),
                'phone' => '+234 800 000 0003',
                'role' => 'sales',
                'branch_id' => $branch->id,
            ]
        );
        $salesOne->password = Hash::make('YnP*3cgi7}Ye7)i8');
        $salesOne->save();
        $salesOne->assignRole($salesRole);

        $salesTwo = User::firstOrCreate(
            ['email' => 'salestwo@cutiehya.ng'],
            [
                'name' => 'Sales Person Two',
                'display_name' => 'Sales Two',
                'email' => 'salestwo@cutiehya.ng',
                'password' => Hash::make('gP&5_f;6mzB_g1,h'),
                'phone' => '+234 800 000 0004',
                'role' => 'sales',
                'branch_id' => $branch->id,
            ]
        );
        $salesTwo->password = Hash::make('gP&5_f;6mzB_g1,h');
        $salesTwo->save();
        $salesTwo->assignRole($salesRole);

        $accounting = User::firstOrCreate(
            ['email' => 'accounting@cutietyha.com'],
            [
                'name' => 'Accounting User',
                'display_name' => 'Accounting',
                'password' => Hash::make('password'),
                'phone' => '+234 800 000 0005',
                'role' => 'accounting',
                'branch_id' => $branch->id,
            ]
        );
        $accounting->assignRole($accountingRole);

        // Create products
        $products = [
            [
                'name' => 'Premium Rice',
                'sku' => 'RICE-001',
                'description' => 'High quality premium rice, 50kg bag',
                'price' => to_kobo(25000), // ₦25,000.00
                'cost' => to_kobo(22000), // ₦22,000.00
                'unit' => 'bag',
            ],
            [
                'name' => 'Granulated Sugar',
                'sku' => 'SUGAR-001',
                'description' => 'Fine granulated sugar, 25kg bag',
                'price' => to_kobo(15000), // ₦15,000.00
                'cost' => to_kobo(13000), // ₦13,000.00
                'unit' => 'bag',
            ],
            [
                'name' => 'Coca Cola',
                'sku' => 'DRINK-001',
                'description' => 'Coca Cola soft drink, 50cl bottle',
                'price' => to_kobo(150), // ₦150.00
                'cost' => to_kobo(120), // ₦120.00
                'unit' => 'bottle',
            ],
            [
                'name' => 'Pepsi',
                'sku' => 'DRINK-002',
                'description' => 'Pepsi soft drink, 50cl bottle',
                'price' => to_kobo(150), // ₦150.00
                'cost' => to_kobo(120), // ₦120.00
                'unit' => 'bottle',
            ],
            [
                'name' => 'Cooking Oil',
                'sku' => 'OIL-001',
                'description' => 'Vegetable cooking oil, 5L',
                'price' => to_kobo(3500), // ₦3,500.00
                'cost' => to_kobo(3000), // ₦3,000.00
                'unit' => 'bottle',
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create(array_merge($productData, [
                'branch_id' => $branch->id,
                'active' => true,
            ]));

            // Create inventory
            Inventory::create([
                'branch_id' => $branch->id,
                'product_id' => $product->id,
                'qty' => rand(20, 100),
                'min_threshold' => 10,
            ]);
        }
    }
}

