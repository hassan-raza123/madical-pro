<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'rent_transaction_id',
        'invoice_no',
        'lpo_no',
        'from_date',
        'to_date',
        'vat'
    ];

    public function equipments()
    {
        return $this->hasMany(InvoiceEquipments::class, 'invoice_id', 'id');
    }
    public function transaction()
    {
        return $this->hasOne(RentTransactions::class, 'id', 'rent_transaction_id');
    }
    
}
