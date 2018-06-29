<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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


    /**
     * Convet array to string conversion
     */
    // public function setSignatoriesAttribute($value)
    // {
    //     $this->attributes['signatories'] = json_encode($value, JSON_UNESCAPED_SLASHES);
    // }

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

}
