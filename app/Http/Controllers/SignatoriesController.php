<?php

namespace App\Http\Controllers;

use App\Http\Resources\SignatoryResource;
use Illuminate\Http\Request;
use App\Signatory;

class SignatoriesController extends Controller
{
    public function getSignatories()
    {
       $signatories = Signatory::all();
        return SignatoryResource::collection($signatories);
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
            'last_name' => 'required',
        ]);

        $signatory = Signatory::create($request->all());

        return response()->json(new SignatoryResource($signatory), 200);

    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signatory $signatory)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $signatory->update($request->all());

        return response()->json(new SignatoryResource($signatory), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signatory $signatory)
    {
        $signatory->delete();
        return response()->json(new SignatoryResource($signatory), 200);
    }

}
