<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'clever_id');
    }

    protected $casts = [
        'updated_at' => 'datetime',
    ];
}
