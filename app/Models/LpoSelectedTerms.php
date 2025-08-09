<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LpoSelectedTerms extends Model
{
    use HasFactory;

    protected $fillable = [
        'lpo_id',
        'term_id'
    ];
    public function term()
    {
        return $this->hasOne(LpoTerms::class, 'id', 'term_id');
    }
}
