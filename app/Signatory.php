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
        $middleInitial = $this->middle_name ? strtoUpper(substr($this->middle_name, 0, 1))."." : '';
        return "{$this->title} {$this->first_name} ".$middleInitial." {$this->last_name}";
    }

    // Relationship Model

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class)->withPivot('policy_type');
    }

    // Json Array

    public function toArray()
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'policy_type' => $this->pivot->policy_type
        ];
    }
}
