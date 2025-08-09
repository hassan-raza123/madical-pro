<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiredDocuments extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'issue_date',
        'expiry_date',
        'description',
        'file_path'
    ];
}
