<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\CustomerDocuments;
use App\Models\EquipmentCategories;

class Equipments extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'company_id',
        'reg_no',
        'model_year',
        'type',
        'image',
        'status'
    ];

    public function documents()
    {
        return $this->hasMany(Documents::class, 'doc_owner_id', 'id');
    }
    public function category()
    {
        return $this->hasOne(EquipmentCategories::class, 'id', 'category_id');
    }
    public function company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }
    public function rent_equipments()
    {
        return $this->hasMany(RentEquipments::class, 'equipment_id', 'id');
    }

}
