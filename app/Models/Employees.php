<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'company_id',
        'mobile',
        'country',
        'state',
        'city',
        'image',
        'type',
        'status'
    ];

    public function documents()
    {
        return $this->hasMany(Documents::class, 'doc_owner_id', 'id');
    }
}
