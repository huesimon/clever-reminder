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

    public function isSubsribed()
    {
        return $this->subscribers()->where('user_id', auth()->id())->exists();
    }

    public function availability()
    {
        return $this->hasOne(Availability::class, 'location_id', 'clever_id');
    }

    public function chargePoints()
    {
        return $this->hasMany(ChargePoint::class);
    }

    public function connectors()
    {
        return $this->hasManyThrough(Connector::class, ChargePoint::class);
    }

    public static function findByOrFail($column, $value)
    {
        return Location::where($column, $value)->firstOrFail();
    }

    public function getConnectorTypes()
    {
        $result = collect();
        foreach ($this->connectors as $connector) {
            $result->push($connector->type);
        }
        return $result->unique();
    }


    protected $casts = [
        'is_future' => 'boolean',
        'is_open24' => 'boolean',
        'is_remote_charging_supported' => 'boolean',
        'is_roaming' => 'boolean',
        'is_admin' => 'boolean',
    ];
}
