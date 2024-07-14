<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pr_employee_payroll extends Model
{
    use HasFactory;
    protected $table = 'pr_employee_payroll';

    public function payrollsDetails()
    {
        return $this->belongsTo(pr_payrolls::class, 'payroll_id', 'id');
    }
}
