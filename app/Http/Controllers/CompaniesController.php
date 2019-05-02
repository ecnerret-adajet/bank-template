<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanySignatoriesResource;
use Illuminate\Http\Request;
use App\Company;
use Carbon\Carbon;

class CompaniesController extends Controller
{

    /**
     * Display all company
     */
    public function allCompany()
    {
        $companies = Company::all();
        return CompanyResource::collection($companies);
    }

    /**
     * Get companies
     */
    public function getCompanies()
    {
        $companies = Company::orderBy('id','desc')->get();
        return CompanyResource::collection($companies);
    }

    public function getCompanyAssignedSignatories(Company $company)
    {
        return $company->signatories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            'name' => 'required',
            'department' => 'required',
            'abbrv' => 'required',
            'avatar' => 'required'
        ]);

        $company = Company::create($request->all());

          // Sync array of signatory for primary signatory for a given company [policy_type = 1]
        $company->signatories()->sync($request->input('signatory1'), ['policy_type' => 1]);

        // //check the existing signatory for secondary signatories [policy_type = 2]
        $existingSignatories = $company->secondarySignatories->pluck('id');
        // will compare the given secondary signatory from exisitng secondary signatories = new array
        $addedSignatories = array_diff($request->input('signatory2'), $existingSignatories->toArray());

        //check if input type for secondary signatories has an array passed
        if (count($request->input('signatory2')) < 1) {
            // if empty, all existing secondary signatory will detach
            $company->signatories()->detach($existingSignatories);
        }

        if (count($addedSignatories) > 0) {
            // will attached the filtered array as new secondary signatories [policy_type = 2]
            $company->signatories()->attach($addedSignatories, ['policy_type' => 2]);
        }

        return [
            'data' => new CompanyResource($company),
            'redirect' => route('master-data')
        ];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return new CompanySignatoriesResource($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => 'required',
            'abbrv' => 'required',
            'signatory1' => 'required'
        ],[
            'name.required' => 'Company name is required',
            'abbrv.required' => 'Company abbreviation is required',
            'signatory1.required' => 'Primary signatory is required'
        ]);

        // Update all fields in company
        $company->update($request->all());


        // $existingSignatories1 = $company->primarySignatories->pluck('id');
        // $addedSignatories1 = array_diff($existingSignatories1->toArray(), $request->input('signatory1'));
        // if (count($request->input('signatory1')) < 1) {
        //     $company->signatories()->detach($existingSignatories1);
        // }
        // if (count($addedSignatories1) > 0) {
        //     $company->signatories()->attach($addedSignatories1, ['policy_type' => 1]);
        // }

        // $existingSignatories2 = $company->secondarySignatories->pluck('id');
        // $addedSignatories2 = array_diff($existingSignatories2->toArray(), $request->input('signatory2'));
        // if (count($request->input('signatory2')) < 1) {
        //     $company->signatories()->detach($existingSignatories2);
        // }
        // if (count($addedSignatories2) > 0) {
        //     $company->signatories()->attach($addedSignatories2, ['policy_type' => 2]);
        // }



       // Sync array of signatory for primary signatory for a given company [policy_type = 1]
        $company->signatories()->sync($request->input('signatory1'), ['policy_type' => 1]);


        // //check the existing signatory for secondary signatories [policy_type = 2]
        $existingSignatories = $company->secondarySignatories->pluck('id');
        // will compare the given secondary signatory from exisitng secondary signatories = new array
        $addedSignatories = array_diff($request->input('signatory2'), $existingSignatories->toArray());

        //check if input type for secondary signatories has an array passed
        if (count($request->input('signatory2')) < 1) {
            // if empty, all existing secondary signatory will detach
            $company->signatories()->detach($existingSignatories);
        }

        if (count($addedSignatories) > 0) {
            // will attached the filtered array as new secondary signatories [policy_type = 2]
            $company->signatories()->attach($addedSignatories, ['policy_type' => 2]);
        }

        return [
            'data' => new CompanyResource($company),
            'redirect' => route('master-data')
        ];
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
