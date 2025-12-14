<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'qty',
        'unit_price',
        'discount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'qty' => 'integer',
        'unit_price' => 'integer',
        'discount' => 'integer',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product for the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant for the order item.
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Calculate subtotal (qty * unit_price - discount).
     */
    public function getSubtotalAttribute(): int
    {
        return ($this->qty * $this->unit_price) - $this->discount;
    }

    /**
     * Get formatted subtotal attribute.
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return format_money($this->subtotal);
    }
}

