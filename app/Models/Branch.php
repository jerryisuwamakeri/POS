<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_id',
        'name',
        'location',
        'geo_lat',
        'geo_lng',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'geo_lat' => 'decimal:8',
        'geo_lng' => 'decimal:8',
    ];

    /**
     * Get the business that owns the branch.
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get the users for the branch.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the products for the branch.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the orders for the branch.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the payments for the branch.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the expenses for the branch.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Get the shifts for the branch.
     */
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    /**
     * Get the inventories for the branch.
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Get the settings for the branch.
     */
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
}

