<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowbedTransactions extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'lowbed_id',
        'company_id',
        'customer_id',
        'from_location',
        'to_location',
        'status',
        'date',
        'description'
    ];

    public function lowbed()
    {
        return $this->hasOne(Lowbeds::class, 'id', 'lowbed_id');
    }
    public function company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }
    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }
}
