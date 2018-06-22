<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = [
        'title',
        'first_name',
        'middle_name',
        'last_name'
    ];

    //Relationship Model

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    // Mutator

    public function getFullNameAttribute()
    {
        return "{$this->title} {$this->first_name} ".strtoUpper(substr($this->middle_name, 0, 1)).", {$this->last_name}";
    }

    public function getFullNameLocationAttribute()
    {
        return $this->full_name." - ".$this->bank->name;
    }



}
