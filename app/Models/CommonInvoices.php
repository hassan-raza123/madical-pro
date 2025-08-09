<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonInvoices extends Model
{
    use HasFactory;

    protected $filleable = [
        'company_id',
        'customer_id',
        'invoice_no',
        'description',
        'amount',
        'date',
        'vat'
    ];

    public function company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }
    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }
}
