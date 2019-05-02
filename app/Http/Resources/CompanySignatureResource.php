<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CompanySignatureResource extends Resource
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
            'company' => $this->company->id,
            'signatory' => $this->signatory->id,
            'policy_type' => $this->policy_type,
            'created_at' => (string) $this->created_at
        ];
    }
}
