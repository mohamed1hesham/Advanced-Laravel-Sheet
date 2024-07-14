<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hrc_employee_assignments extends Model
{
    use HasFactory;
    public function employee()
    {
        return $this->belongsTo(hrc_employees::class, 'person_id', 'person_id');
    }
}