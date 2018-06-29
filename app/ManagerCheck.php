<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * Convet array to string conversion
     */
    public function setSignatoriesAttribute($value)
    {
        $this->attributes['signatories'] = json_encode($value);
    }

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
        return $this->belongsTo(manager::class);
    }

    public function payees()
    {
        return $this->hasMany(Payee::class);
    }
}
