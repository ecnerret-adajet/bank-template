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

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = trim(str_replace(['PHP',',','.'],'',$value));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
