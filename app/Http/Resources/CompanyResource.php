<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CompanyResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'department' => $this->department,
            'abbrv' => $this->abbrv,
            'avatar' => $this->avatar,
            'location' => $this->location,
            'bank_code' => $this->location,
        ];
    }
}
