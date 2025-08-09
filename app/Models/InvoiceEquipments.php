<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceEquipments extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'transaction_equip_id',
        'price_type',
        'unit_price',
        'total_hours',
        'mobilization',
        'demobilization'
    ];

    public function transaction_equipments()
    {
        return $this->hasOne(RentEquipments::class, 'id', 'transaction_equip_id');
    }
    public function invoice()
    {
        return $this->hasOne(invoices::class, 'id', 'invoice_id');
    }
}
