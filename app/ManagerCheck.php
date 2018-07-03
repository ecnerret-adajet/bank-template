<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ManagerCheck extends Model
{

    protected $table = 'manager_checks';

    protected $fillable = [
        'ref_num',
        'mc_cost',
        'grand_total',
        'account_number',
        'company',
        'signatories'
    ];

    // cast to array
    protected $casts = [
        'signatories' => 'array',
    ];

    public function setGrandTotalAttribute($value)
    {
        $this->attributes['grand_total'] = trim(str_replace(['PHP',',','.00'],'',$value));
    }

    public function setMcCostAttribute($value)
    {
        $this->attributes['mc_cost'] = trim(str_replace(['PHP',',','.00'],'',$value));
    }
    
    // Model Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function payees()
    {
        return $this->hasMany(Payee::class);
    }

    //Queue Scope

    public function scopeCurrentUser($query) 
    {
        return $query->where('user_id',Auth::user()->id)->get();
    } 


    // Custom JSON casting
    public function toArray()
    {
        return [
            'id' => $this->id,
            'ref_num' => $this->ref_num,
            'mc_cost' => $this->mc_cost,
            'grand_total' => $this->grand_total,
            'account_number' => $this->account_number,
            'company' => $this->company,
            'manager' => $this->manager->full_name,
            'payees' => $this->payees,
            'signatories' => $this->signatories,
            'user' => $this->user->name,
            'created_at' => $this->created_at
        ];
    }
}
