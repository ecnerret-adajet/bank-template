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

    protected $hidden = [
        'created_at','updated_at'
    ];

    // Model Relationship

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function manager()
    {
        return $this->hasOne(Manager::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

}
