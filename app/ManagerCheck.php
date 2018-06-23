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
        'account_number'
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
}
