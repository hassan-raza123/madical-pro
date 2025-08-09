<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedQuotationTerms extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'term'
    ];

    public function term_text()
    {
        return $this->hasOne(QuotationTerms::class, 'id', 'term');
    }
}
