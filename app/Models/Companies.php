<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'fax',
        'mobile',
        'email',
        'website',
        'bank',
        'bank_account_no',
        'bank_branch',
        'bank_swift_code',
        'logo',
        'signature_img',
        'invoice_bg'
    ];
}
