<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $unguard = [
        '*',
    ];

    // Model Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(manager::class);
    }

    public function signatory()
    {
        return $this->belongsTo(Signatory::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }


}
