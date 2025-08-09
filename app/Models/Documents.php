<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_owner_id',
        'doc_owner_name',
        'doc_name_id',
        'issue_date',
        'expiry_date',
        'description',
        'file_path'
    ];

    public function doc_name()
    {
        return $this->hasOne(DocumentNames::class, 'id', 'doc_name_id');
    }
    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'doc_owner_id');
    }
    public function employee()
    {
        return $this->hasOne(Employees::class, 'id', 'doc_owner_id');
    }
    public function equipment()
    {
        return $this->hasOne(Equipments::class, 'id', 'doc_owner_id');
    }
}
