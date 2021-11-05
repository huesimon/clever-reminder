<?php

namespace App\Http\Resources;

use App\Models\Availability;
use Illuminate\Http\Resources\Json\JsonResource;

class CleverAvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Availability $availability
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($availability)
    {
        return [
            'available' => [
                'ccs' => [
                    'fast' => $availability->available_ccs_fast,
                    'ultra' => $availability->available_ccs_ultra,
                ],
                'chademo' => [
                    'fast' => $availability->available_chademo_fast,
                    'ultra' => $availability->available_chademo_ultra,
                ],
                'iec_type_2' => [
                    'fast' => $availability->available_iec_type_2_fast,
                    'regular' => $availability->available_iec_type_2_regular,
                ],
            ],
            'functional' => [
                'ccs' => [
                    'fast' => $availability->functional_ccs_fast,
                    'ultra' => $availability->functional_ccs_ultra,
                ],
                'chademo' => [
                    'fast' => $availability->functional_chademo_fast,
                    'ultra' => $availability->functional_chademo_ultra,
                ],
                'iec_type_2' => [
                    'fast' => $availability->functional_iec_type_2_fast,
                    'regular' => $availability->functional_iec_type_2_regular,
                ],
            ],
            'total' => [
                'ccs' => [
                    'fast' => $availability->total_ccs_fast,
                    'ultra' => $availability->total_ccs_ultra,
                ],
                'chademo' => [
                    'fast' => $availability->total_chademo_fast,
                    'ultra' => $availability->total_chademo_ultra,
                ],
                'iec_type_2' => [
                    'fast' => $availability->total_iec_type_2_fast,
                    'regular' => $availability->total_iec_type_2_regular,
                ],
            ],
        ];
    }
}
