<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedOil extends Model
{
    use HasFactory;

    protected $fillable = [
        'oil_id',
        'fleet_service_id',
        'quantity'
    ];

    public function oil()
    {
        return $this->hasOne(Oil::class, 'id', 'oil_id');
    }
}
