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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
        ]);

        $signatory = Signatory::create($request->all());

        return $signatory;

    }

}
