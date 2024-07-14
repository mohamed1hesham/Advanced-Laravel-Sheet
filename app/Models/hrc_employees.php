<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hrc_employees extends Model
{
    use HasFactory;


    public function assignments()
    {
        return $this->hasMany(hrc_employee_assignments::class, 'person_id', 'person_id');
    }

    public function EmployeePayroll()
    {
        return $this->hasOne(pr_employee_payroll::class, 'person_id', 'person_id');
    }
}
