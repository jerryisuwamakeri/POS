<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'address',
        'email',
        'phone',
        'subscription_status',
    ];

    /**
     * Get the branches for the business.
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}

