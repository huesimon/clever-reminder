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
    const IEC_TYPE_2_REGULAR = 'available_iec_type_2_regular';

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'clever_id');
    }

    public function getSpotsByPlugType(string $type)
    {
        switch (Connector::getPlugType($type)) {
            case Connector::CCS:
                return $this->getAttribute(self::CCS_FAST) + $this->getAttribute(self::CCS_ULTRA);
            case Connector::CHADEMO:
                return $this->getAttribute(self::CHADEMO_FAST) + $this->getAttribute(self::CHADEMO_ULTRA);
            case Connector::IEC_TYPE_2:
                return $this->getAttribute(self::IEC_TYPE_2_FAST) + $this->getAttribute(self::IEC_TYPE_2_REGULAR);
        }
    }

    protected $casts = [
        'updated_at' => 'datetime',
    ];
}
