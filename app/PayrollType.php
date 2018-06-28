<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollType extends Model
{
    protected $table = 'payroll_types';

    protected $fillable = [
        'name'
    ];

    // Casting Json object

    public function toArray()
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
