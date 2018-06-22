<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'account_number'
    ];

    // Relationship Model
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
