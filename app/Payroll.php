<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Payroll extends Model
{
    protected $fillable = [
        'ref_num',
        'signatories'
    ];

    // cast to array
    protected $casts = [
        'signatories' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
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

    //Queue Scope

    public function scopeCurrentUser($query)
    {
        return $query->where('user_id',Auth::user()->id)->get();
    }

    // Custom JSON Casting

    public function toArray()
    {
        return [
            'id' => $this->id,
            'ref_num' => $this->ref_num,
            'manager' => $this->manager->full_name,
            'type' => $this->type->name,
            'company' => $this->company->full_company,
            'applicants' => $this->applicants,
            'signatories' => $this->signatories,
            'user' => $this->user->name,
            'created_at' => $this->created_at
        ];
    }


}
