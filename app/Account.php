<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'account_number'
    ];

    protected $hidden = [
        'bank_id',
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'account_number' => $this->account_number,
            'bank' => $this->bank->branch,
            'company' => $this->company
        ];
    }

    // Relationship Model
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
