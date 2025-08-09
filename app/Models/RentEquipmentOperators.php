<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentEquipmentOperators extends Model
{
    use HasFactory;

    protected $fillable = [
        'rent_equipment_id',
        'employee_id'
    ];

    public function employee()
    {
        return $this->hasOne(Employees::class, 'id', 'employee_id');
    }
}
