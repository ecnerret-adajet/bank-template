<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Signatory;

class SignatoriesController extends Controller
{
    public function getSignatories()
    {
       $signatories = Signatory::all();
       return $signatories;
    }

}
