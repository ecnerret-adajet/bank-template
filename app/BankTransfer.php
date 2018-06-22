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
        'amount'
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
