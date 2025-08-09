<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'customer_id',
        'quotation_id',
        'payment_method',
        'from_date',
        'to_date',
        'location',
        'status'
    ];

    public function equipments()
    {
        return $this->hasMany(RentEquipments::class, 'rent_transaction_id', 'id');
    }
    public function company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }
    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }
    public function quotation()
    {
        return $this->hasOne(Quotations::class, 'id', 'quotation_id');
    }
    public function invoices()
    {
        return $this->hasMany(Invoices::class, 'rent_transaction_id', 'id');
    }
}
