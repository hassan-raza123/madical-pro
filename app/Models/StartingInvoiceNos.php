<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartingInvoiceNos extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'invoice_no',
        'quot_no',
        'lpo_no'
    ];
}
