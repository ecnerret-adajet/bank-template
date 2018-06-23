<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payee extends Model
{
    protected $fillable =  [
        'name',
        'nature',
        'ref_num',
        'amount'
    ];

    // Model Relationship

    public function managerCheck()
    {
        return $this->belongsTo(ManagerCheck::class);
    }
}
