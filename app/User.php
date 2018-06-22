<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relationship Model

    public function bankTransfers()
    {
        return $this->hasMany(BankTransfer::class);
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function signatories()
    {
        return $this->hasMany(Signatory::class);
    }



}
