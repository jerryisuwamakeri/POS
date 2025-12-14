<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class POSCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::create(['name' => 'sales']);
        Role::create(['name' => 'admin']);

        // Create business and branch
        $business = Business::create([
            'name' => 'Test Business',
            'slug' => 'test-business',
            'subscription_status' => 'active',
        ]);

        $this->branch = Branch::create([
            'business_id' => $business->id,
            'name' => 'Test Branch',
            'location' => 'Test Location',
        ]);

        // Create sales user
        $this->user = User::create([
            'name' => 'Sales User',
            'email' => 'sales@test.com',
            'password' => bcrypt('password'),
            'branch_id' => $this->branch->id,
        ]);
        $this->user->assignRole('sales');

        // Create product with inventory
        $this->product = Product::create([
            'branch_id' => $this->branch->id,
            'name' => 'Test Product',
            'sku' => 'TEST-001',
            'price' => 10000, // ₦100.00 in kobo
            'cost' => 8000,
            'unit' => 'pcs',
            'active' => true,
        ]);

        Inventory::create([
            'branch_id' => $this->branch->id,
            'product_id' => $this->product->id,
            'qty' => 100,
            'min_threshold' => 10,
        ]);
    }

    public function test_sales_user_can_checkout(): void
    {
        $response = $this->actingAs($this->user)->postJson('/pos/checkout', [
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'qty' => 2,
                ],
            ],
            'payment_method' => 'cash',
            'customer_name' => 'Test Customer',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('orders', [
            'branch_id' => $this->branch->id,
            'user_id' => $this->user->id,
            'customer_name' => 'Test Customer',
            'status' => 'paid',
        ]);

        // Check inventory was updated
        $inventory = Inventory::where('product_id', $this->product->id)->first();
        $this->assertEquals(98, $inventory->qty);
    }

    public function test_checkout_fails_with_insufficient_stock(): void
    {
        $response = $this->actingAs($this->user)->postJson('/pos/checkout', [
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'qty' => 200, // More than available
                ],
            ],
            'payment_method' => 'cash',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
        ]);
    }
}

