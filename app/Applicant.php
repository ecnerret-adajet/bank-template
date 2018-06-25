<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'name',
        'company',
        'branch',
        'status',
    ];

    // Model Relationship

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
