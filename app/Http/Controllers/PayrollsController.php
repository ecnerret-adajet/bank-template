<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Payroll;
use App\Applicant;
use App\Company;
use App\Signatory;
use App\Manager;
use PDF;

class PayrollsController extends Controller
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
            'company' => 'required',
            'branch' => 'required'
        ]);

        $applicant = Auth::user()->applicants()->create([
            'name' => $request->input('name'),
            'company' => $request->input('company'),
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
            'signatory_list' => 'required'
        ]);

        $last_count = !empty(Payroll::first()) ? Payroll::orderBy('id','DESC')->first()->id : 0;

        $payroll = new Payroll;
        $payroll->user_id = Auth::user()->id;
        $payroll->ref_num = 'LFUGGOC-PA-'.sprintf('%08d', $last_count);
        $payroll->manager()->associate($request->input('manager_list'));
        $payroll->signatory()->associate($request->input('signatory_list'));
        $payroll->save();

        $applicant = Applicant::where('user_id', Auth::user()->id)
                                ->where('status',0)
                                ->where('payroll_id',0)
                                ->update([ 'payroll_id' => $payroll->id ]);

        return redirect('payrolls/'.$payroll->id);
    }

    /**
     * Generate PDF from payroll application
     */
    public function generatePDF(Payroll $x)
    {
        $pdf = PDF::loadView('payrolls.pdf', compact('x'));
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
