<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BankTransfer extends Model
{
    protected $table = 'bank_transfers';

    protected $fillable = [
        'ref_num',
        'from_company',
        'to_company',
        'from_account',
        'to_account',
        'amount',
        'signatories',
    ];

    // cast to array
    protected $casts = [
        'signatories' => 'array',
    ];

    // Custom json cast
    public function toArray()
    {
        return [
            'id' => $this->id,
            'ref_num' => $this->ref_num,
            'from_company' => $this->from_company,
            'to_company' => $this->to_company,
            'from_account' => $this->from_account,
            'to_account' => $this->to_account,
            'amount' => $this->amount,
            'signatories' => $this->signatories,
            'manager' => $this->manager->full_name,
            'bank' => $this->bank,
            'user' => $this->user->name,
            'created_at' => $this->created_at
        ];
    }

    // Attribute Mutator

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = trim(str_replace(['PHP',',','.00'],'',$value));
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

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    //Queue Scope

    public function scopeCurrentUser($query) 
    {
        return $query->where('user_id',Auth::user()->id)->get();
    } 

}
