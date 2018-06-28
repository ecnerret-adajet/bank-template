<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'ref_num',
        'signatories'
    ];

    // Model Relationships
    /**
     * Convet array to string conversion
     */
    public function setSignatoriesAttribute($value)
    {
        $this->attributes['signatories'] = json_encode($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(manager::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    public function type()
    {
        return $this->belongsTo(PayrollType::class,'payroll_type_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


}
