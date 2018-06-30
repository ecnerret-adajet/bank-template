<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'department',
        'abbrv',
        'avatar'
    ];

    protected $appends = ['full_company'];

    public function getFullCompanyAttribute()
    {
        return !empty($this->department) ? $this->name." - ".$this->department : $this->name;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->full_company,
        ];
    }

}
