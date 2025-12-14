<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Branch;
use App\Models\Business;
use App\Models\Shift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class ShiftClockInOutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::create(['name' => 'sales']);

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
    }

    public function test_user_can_clock_in(): void
    {
        $response = $this->actingAs($this->user)->postJson('/api/shifts/clock-in', [
            'geo_lat' => 10.5105,
            'geo_lng' => 7.4165,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('shifts', [
            'user_id' => $this->user->id,
            'branch_id' => $this->branch->id,
            'clock_out_at' => null,
        ]);
    }

    public function test_user_can_clock_out(): void
    {
        // First clock in
        $shift = Shift::create([
            'user_id' => $this->user->id,
            'branch_id' => $this->branch->id,
            'clock_in_at' => now()->subHours(2),
        ]);

        // Then clock out
        $response = $this->actingAs($this->user)->postJson('/api/shifts/clock-out');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $shift->refresh();
        $this->assertNotNull($shift->clock_out_at);
        $this->assertNotNull($shift->duration_minutes);
    }

    public function test_user_cannot_clock_in_twice(): void
    {
        // Clock in first time
        Shift::create([
            'user_id' => $this->user->id,
            'branch_id' => $this->branch->id,
            'clock_in_at' => now(),
        ]);

        // Try to clock in again
        $response = $this->actingAs($this->user)->postJson('/api/shifts/clock-in');

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'You already have an active shift',
        ]);
    }
}

