<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CCS_FAST = 'available_ccs_fast';
    const CCS_ULTRA = 'available_ccs_ultra';
    const CHADEMO_FAST = 'available_chademo_fast';
    const CHADEMO_ULTRA = 'available_chademo_ultra';
    const IEC_TYPE_2_FAST = 'available_iec_type_2_fast';
    const IEC_TYPE_2_ULTRA = 'available_iec_type_2_ultra';

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'clever_id');
    }

    protected $casts = [
        'updated_at' => 'datetime',
    ];
}
