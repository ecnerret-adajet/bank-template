<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BankResource extends Resource
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
            'branch' => $this->branch,
            'location' => $this->location,
            'created_at' => (string) $this->created_at
        ];
    }
}
