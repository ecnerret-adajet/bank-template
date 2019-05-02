<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CompanySignatoriesResource extends Resource
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
            'abbrv' => $this->abbrv,
            'department' => $this->department,
            'avatar' => $this->avatar,
            'signatories' => $this->signatories
        ];
    }
}
