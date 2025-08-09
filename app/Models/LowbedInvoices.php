<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowbedInvoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'lowbed_transaction_id',
        'description',
        'amount',
        'date',
        'vat'
    ];

    public function transaction()
    {
        return $this->hasOne(LowbedTransactions::class, 'id', 'lowbed_transaction_id');
    }
}
