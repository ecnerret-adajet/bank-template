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

    protected $hidden = [
        'bank_id',
    ];

    //Relationship Model

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    // Mutator

    public function getFullNameAttribute()
    {
        $middleInitial = $this->middle_name ? strtoUpper(substr($this->middle_name, 0, 1))."." : '';
        return "{$this->title} {$this->first_name} ".$middleInitial." {$this->last_name}";
    }

    public function getFullNameLocationAttribute()
    {
        return $this->full_name." - ".$this->bank->name;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'bank' => $this->bank->name,
            'branch' => $this->bank->branch
        ];
    }



}
