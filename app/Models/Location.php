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
}
