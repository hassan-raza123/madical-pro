<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotations extends Model
{
    use HasFactory;

    protected $fillable = [
        'quot_no',
        'company_id',
        'customer_id',
        'payment_method',
        'status'
    ];

    public function quot_equipments()
    {
        return $this->hasMany(QuotationEquipments::class, 'quotation_id', 'id');
    }
    public function quot_terms()
    {
        return $this->hasMany(SelectedQuotationTerms::class, 'quotation_id', 'id');
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
