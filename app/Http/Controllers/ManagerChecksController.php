<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CompanyTraits;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\ManagerCheck;
use App\Payee;
use App\Manager;
use App\Account;
use App\Signatory;
use App\Company;
use App\Bank;
use PDF;

class ManagerChecksController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::pluck('name','name');
        $accounts = Account::pluck('account_number','account_number');
        $managers = Manager::get()->pluck('full_name','id');
        $signatories = Signatory::get()->pluck('full_name','id');

        return view('managerChecks.create',compact('accounts',
                    'managers',
                    'companies',
                    'signatories'));
    }

    /**
     * Get payees data
     */
    public function getPayee()
    {
        $payees = Payee::where('user_id', Auth::user()->id)
                        ->where('status',0)
                        ->where('manager_check_id',0)
                        ->get();

        return $payees;
    }


    /**
     * Store payees
     */
    public function storePayee(Request $request, $user_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'nature' => 'required',
            'ref_num' => 'required',
            'amount' => 'required'
        ]);

        $payee =  new Payee;
        $payee->user_id = $user_id;
        $payee->name = $request->input('name');
        $payee->nature = $request->input('nature');
        $payee->ref_num = $request->input('ref_num');
        $payee->amount = $request->input('amount');
        $payee->status = 0;
        $payee->save();

        return $payee;
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
            'bank_id' => 'required',
            'account_id' => 'required',
            'signatory1' => 'required',
            'signatory2' => 'required',
            'grand_total' => 'required',
            'mc_cost' => 'required',
        ]);

        $last_count = !empty(ManagerCheck::first()) ? ManagerCheck::orderBy('id','DESC')->first()->id : 0;
        $bank = Bank::whereId($request->input('bank_id'))->first();
        $account = Account::where('id',$request->input('account_id'))->with('company')->first();

        $managercheck = Auth::user()->managerChecks()->create([
            'ref_num' => $account->company->abbrv.'-MC-'.sprintf('%08d', $last_count),
            'mc_cost' => $request->input('mc_cost'),
            'grand_total' => $request->input('grand_total'),
            'account_number' => $account->account_number,
            'company' => $account->company->full_company,
            'signatories' => [
                array('name' => $request->input('signatory1')),
                array('name' => $request->input('signatory2'))
            ]
        ]);
        $managercheck->manager()->associate($bank->manager->id);
        $managercheck->save();

        $payee = Payee::where('user_id', Auth::user()->id)
                        ->where('status',0)
                        ->where('manager_check_id',0)
                        ->update(['manager_check_id' => $managercheck->id]);

        return ['redirect' => route('manager-checks.show', $managercheck)];

    }

    /**
     * Generate PDF From Bank Transfer
     */
    public function generatePDF(ManagerCheck $x)
    {
        // enable extension=php_intl.dll from PHP.INI to user NumberFormatter

        // $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $img = $this->findCompanyAvatar($x->company);

        $pdf = PDF::loadView('managerChecks.pdf', compact('x','img'));
        return $pdf->setPaper('letter')->stream('managerChecks.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ManagerCheck $manager_check)
    {
        return view('managerChecks.show',compact('manager_check'));
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
    public function payeeStatus(Payee $payee)
    {
        $payee->status = 1;
        return $payee;
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
     * Remove a payee
     */
    public function destroyPayee(Payee $payee)
    {
        $payee->delete();
        return $payee;
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
