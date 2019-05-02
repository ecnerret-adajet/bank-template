<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CompanyTraits;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Payroll;
use App\Applicant;
use App\Company;
use App\Signatory;
use App\Manager;
use App\PayrollType;
use PDF;
use App\Account;

class PayrollsController extends Controller
{

     use CompanyTraits;

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
     * Show payroll application type
     */
    public function getPayrollTypes()
    {
        $payrollTypes = PayrollType::all();
        return $payrollTypes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $managers = Manager::get()->pluck('full_name','id');
        $signatories = Signatory::get()->pluck('full_name','id');

        return view('payrolls.create',compact(
                    'managers',
                    'signatories'));
    }

    /**
     * Get Applicants
     */
    public function getApplicant()
    {
        $applicants = Applicant::where('user_id', Auth::user()->id)
                        ->where('status',0)
                        ->where('payroll_id',0)
                        ->get();

        return $applicants;
    }

    /**
     * Store new applicants
     */
    public function storeApplicant(Request $request, $user_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'branch' => 'required'
        ]);

        $applicant = Auth::user()->applicants()->create([
            'name' => $request->input('name'),
            'branch' => $request->input('branch'),
            'status' => 0,
        ]);

        return $applicant;
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
            'manager_list' => 'required',
            'payroll_type' => 'required',
            'company_list' => 'required',
            'signatory1' => 'required',
            'signatory2' => 'required',
        ]);

        $last_count = !empty(Payroll::first()) ? Payroll::orderBy('id','DESC')->first()->id : 0;
        $reference = Account::where('id',$request->input('company_list'))->with('company')->first();

        $payroll = Auth::user()->payrolls()->create([
            'ref_num' => $reference->company->abbrv.'-PA-'.sprintf('%08d', $last_count),
            'signatories' => [
                array('name' => $request->input('signatory1')),
                array('name' => $request->input('signatory2'))
            ]
        ]);
        $payroll->type()->associate($request->input('payroll_type'));
        $payroll->manager()->associate($request->input('manager_list'));
        $payroll->company()->associate($request->input('company_list'));
        $payroll->save();

        $applicant = Applicant::where('user_id', Auth::user()->id)
                                ->where('status',0)
                                ->where('payroll_id',0)
                                ->update([ 'payroll_id' => $payroll->id ]);

        return ['redirect' => route('payrolls.show', $payroll)];
    }

    /**
     * Generate PDF from payroll application
     */
    public function generatePDF(Payroll $x)
    {
        $img = $this->findCompanyAvatar($x->company->name);
        $pdf = PDF::loadView('payrolls.pdf', compact('x','img'));
        return $pdf->setPaper('letter')->stream('payrolls.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Payroll $payroll)
    {
        return view('payrolls.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Change Payee Status
     */
    public function statusApplicant(Applicant $applicant)
    {
        $applicant->status = 1;
        return $applicant;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove an applicant
     */
    public function destroyApplicant(Applicant $applicant)
    {
        $applicant->delete();
        return $applicant;
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
