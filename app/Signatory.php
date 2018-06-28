<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signatory extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
    ];

    // Mutator
    
    public function getFullNameAttribute()
    {
        return "{$this->first_name} ".strtoUpper(substr($this->middle_name, 0, 1)).", {$this->last_name}";
    }
    
    // Relationship Model

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Json Array

    public function toArray()
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name
        ];
    }
}
