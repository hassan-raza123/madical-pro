<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeExpenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'expense_name_id',
        'amount',
        'date',
        'description'
    ];

    public function employee()
    {
        return $this->hasOne(Employees::class, 'id', 'employee_id');
    }

    public function expense_name()
    {
        return $this->hasOne(EmployeeExpenseNames::class, 'id', 'expense_name_id');
    }
}
