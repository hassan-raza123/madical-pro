<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowbeds extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'reg_no',
        'model_year'
    ];

    public function company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }

}
