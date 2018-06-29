<?php

namespace App\Traits;

use App\Company;


trait CompanyTraits {

    public function findCompanyAvatar($company) {

        $img = Company::where('name',$company)->first()->avatar;
        return $img;   
    
    }

}