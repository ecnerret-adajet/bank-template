<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySignatory extends Model
{

    protected $table = "company_signatory";

    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function signatory()
    {
        return $this->belongsTo(Signatory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
