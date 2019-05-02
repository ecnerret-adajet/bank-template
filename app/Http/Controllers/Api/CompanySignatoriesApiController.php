<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanySignatureResource;
use App\CompanySignatory;
use Carbon\Carbon;

class CompanySignatoriesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'company_id' => 'required',
            'signatory_id' => 'required',
            'policy_type' => 'required',
            'user_id' => 'required' // test
        ]);

        $companySignatory = CompanySignatory::create([
            // 'user_id' => Auth::user()->id,
            'user_id' => $request->user_id, //
            'company_id' => $request->company_id,
            'signatory_id' => $request->signatory_id,
            'policy_type' => $request->policy_type
        ]);

        return response()->json(new CompanySignatureResource($companySignatory), 200);
    }

    /**
     * Display the specified resource.
     * Based from ID [company_id] show all related signatories
     *
     * @param  int  $id [company_id]
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companySignatories = CompanySignatory::where('company_id', $id)->get();
        return CompanySignatureResource::collection($companySignatories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanySignatory $companySignatory)
    {
        $this->validate($request, [
            'company_id' => 'required',
            'signatory_id' => 'required',
            'policy_type' => 'required',
        ]);
        $companySignatory->update($request->all());
        return response()->json(new CompanySignatureResource($companySignatory), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
