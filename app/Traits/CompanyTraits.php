<?php

namespace App\Traits;

use App\Company;


trait CompanyTraits {

    public function findCompanyAvatar($company) {

        $contains = str_contains($company, '- ') ? substr($company, 0, strrpos($company, '-')) : $company;

        $img = Company::where('name',$contains)->first()->avatar;
        return $img;   
    
    }

}