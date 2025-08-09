<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationEquipments extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'equipment_id',
        'description',
        'operator',
        'hourly_rent',
        'daily_rent',
        'weekly_rent',
        'monthly_rent',
        'mobilization',
        'demobilization'
    ];

    public function equipment()
    {
        return $this->hasOne(Equipments::class, 'id', 'equipment_id');
    }
    public function employee()
    {
        return $this->hasOne(Employees::class, 'id', 'employee_id');
    }
}
