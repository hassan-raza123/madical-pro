<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lpos extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'customer_id',
        'lpo_no',
        'date',
        'vat'
    ];

    public function items()
    {
        return $this->hasMany(LpoItems::class, 'lpo_id', 'id');
    }
    public function company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }
    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }
    public function terms()
    {
        return $this->hasMany(LpoSelectedTerms::class, 'lpo_id', 'id');
    }

}
