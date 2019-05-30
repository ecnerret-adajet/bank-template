<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AccountResource extends Resource
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
            'account_number' => $this->account_number,
            'bank' => $this->bank,
            'company' => $this->company,
            'account_company' =>  $this->account_number." - ".$this->company->abbrv,
            'company_location' => $this->company->location ? $this->account_number." - ".$this->company->abbrv.' - '.$this->company->location->name : $this->account_number." - ".$this->company->abbrv
        ];
    }
}
