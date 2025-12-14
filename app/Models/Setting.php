<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'branch_id',
        'key',
        'value',
    ];

    /**
     * Get the branch that owns the setting.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get setting value by key for a branch.
     */
    public static function getValue(?int $branchId, string $key, $default = null)
    {
        $setting = static::where('branch_id', $branchId)
            ->where('key', $key)
            ->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key for a branch.
     */
    public static function setValue(?int $branchId, string $key, $value): void
    {
        static::updateOrCreate(
            ['branch_id' => $branchId, 'key' => $key],
            ['value' => $value]
        );
    }
}

