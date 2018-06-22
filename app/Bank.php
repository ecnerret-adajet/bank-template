<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable =  [
        'name',
        'branch',
        'location'
    ];

    // Model Relationship

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->hasOne(Account::class);
    }
}
