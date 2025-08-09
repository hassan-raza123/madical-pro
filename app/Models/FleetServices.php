<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FleetServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'services',
        'meter_reading',
        'next_service_meter_reading',
        'meter_reading_unit',
        'description',
        'date'
    ];

    public function equipment()
    {
        return $this->hasOne(Equipments::class, 'id', 'equipment_id');
    }
    public function used_oil()
    {
        return $this->hasOne(UsedOil::class, 'fleet_service_id', 'id');
    }
}
