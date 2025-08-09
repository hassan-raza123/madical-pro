<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oil extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'quantity',
        'price',
        'description',
        'date'
    ];

    public function category()
    {
        return $this->hasOne(OilCategories::class, 'id', 'category_id');
    }

}
