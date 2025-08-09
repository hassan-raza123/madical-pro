<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LpoItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'lpo_id',
        'equipment_id',
        'item_name_id',
        'description',
        'quantity',
        'unit_price'
    ];

    function item_name()
    {
        return $this->hasOne(LpoItemNames::class, 'id', 'item_name_id');
    }
    function equipment()
    {
        return $this->hasOne(Equipments::class, 'id', 'equipment_id');
    }
}
