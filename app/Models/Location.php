<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function subscribers()
    {
        return $this->hasMany(LocationSubscriber::class);
    }

    public function chargePoints()
    {
        return $this->hasMany(ChargePoint::class);
    }

    public static function findByOrFail($column, $value)
    {
        return Location::where($column, $value)->firstOrFail();
    }


    protected $casts = [
        'is_future' => 'boolean',
        'is_open24' => 'boolean',
        'is_remote_charging_supported' => 'boolean',
        'is_roaming' => 'boolean',
        'is_admin' => 'boolean',
    ];
}
