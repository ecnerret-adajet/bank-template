<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'department',
        'abbrv',
        // 'avatar'
    ];

    protected $appends = ['full_company'];

    public function getFullCompanyAttribute()
    {
        return !empty($this->department) ? $this->name." - ".$this->department : $this->name;
    }

    public function signatories()
    {
        return $this->belongsToMany(Signatory::class)->withPivot('policy_type');
    }

    public function secondarySignatories()
    {
        return $this->belongsToMany(Signatory::class)
                       ->withPivot('policy_type')
                       ->wherePivot('policy_type', 2);
    }

    public function primarySignatories()
    {
        return $this->belongsToMany(Signatory::class)
                       ->withPivot('policy_type')
                       ->wherePivot('policy_type', 1);
    }

    // public function scopePolicy()

    // public function toArray()
    // {
    //     return [
    //         'id' => $this->id,
    //         'name' => $this->full_company,
    //         'avatar' => $this->avatar,
    //     ];
    // }

}
