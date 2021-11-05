<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connector extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CCS = 'ccs';
    const CHADEMO = 'chademo';
    const IEC_TYPE_2 = 'iec_type_2';


    public function chargePoint()
    {
        return $this->belongsTo(ChargePoint::class);
    }

    public static function getPlugType($plugType)
    {
        switch ($plugType) {
            case Availability::CCS_FAST:
            case Availability::CCS_ULTRA:
                $plugType = Connector::CCS;
                break;
            case Availability::CHADEMO_FAST:
            case Availability::CHADEMO_ULTRA:
                $plugType = Connector::CHADEMO;
                break;
            case Availability::IEC_TYPE_2_FAST:
            case Availability::IEC_TYPE_2_ULTRA:
                $plugType = Connector::IEC_TYPE_2;
                break;

            default:
                # code...
                break;
        }

        return $plugType;
    }
}
