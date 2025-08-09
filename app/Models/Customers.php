<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\CustomerDocuments;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'telephone',
        'mobile',
        'email',
        'address',
        'country',
        'state',
        'city',
        'cr_no',
        'cr_reg_date',
        'cr_expiry_date',
        'vatin_no',
        'vatin_reg_date',
        'vatin_expiry_date'
    ];

    public function documents()
    {
        return $this->hasMany(Documents::class, 'doc_owner_id', 'id');
    }
    public function rent_transactions()
    {
        return $this->hasMany(RentTransactions::class, 'customer_id', 'id');
    }
}
