<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentEquipments extends Model
{
    use HasFactory;

    protected $fillable = [
        'rent_transaction_id',
        'equipment_id',
        'description',
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
    public function operators()
    {
        return $this->hasMany(RentEquipmentOperators::class, 'rent_equipment_id', 'id');
    }

    public function rent_transaction()
    {
        return $this->hasOne(RentTransactions::class, 'id', 'rent_transaction_id');
    }
    public function invoice_equipments()
    {
        return $this->hasMany(InvoiceEquipments::class, 'transaction_equip_id', 'id');
    }

}
