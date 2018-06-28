<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\BankTransfer;
use Carbon\Carbon;
use App\Bank;
use App\Signatory;
use App\Manager;
use App\Account;
use App\Company;
use PDF;

class BankTransfersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bankTransfers.index');
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
        // $banks = Bank::pluck('branch',);
        $signatories = Signatory::get()->pluck('full_name','id');
        
        return view('bankTransfers.create',compact('accounts',
                    'managers',
                    'companies',
                    'signatories'));
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
            'amount' => 'required',
            'from_company' => 'required',
            'to_company' => 'required',
            'from_account' => 'required',
            'to_account' => 'required',
            'manager_list' => 'required',
            'signatory_list' => 'required',
        ]);

        $last_count = !empty(BankTransfer::first()) ? BankTransfer::orderBy('id','DESC')->first()->id : 0;
        
        $bankTransfer = Auth::user()->bankTransfers()->create([
            'ref_num' => 'PFMC-BT-'.sprintf('%08d', $last_count),
            'amount' => $request->input('amount'),
            'from_company' => $request->input('from_company'),
            'to_company' => $request->input('to_company'),
            'from_account' => $request->input('from_account'),
            'to_account' => $request->input('to_account'),
        ]);
        $bankTransfer->manager()->associate($request->input('manager_list'));
        $bankTransfer->signatory()->associate($request->input('signatory_list'));
        $bankTransfer->save();

        return redirect('bank-transfers/'.$bankTransfer->id);
    }

    /**
     * Generate PDF From Bank Transfer
     */
    public function generatePDF(BankTransfer $x)
    {
        // enable extension=php_intl.dll from PHP.INI to user NumberFormatter

        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);

        $pdf = PDF::loadView('bankTransfers.pdf', compact('x','f'));
        return $pdf->setPaper('letter')->stream('bankTransfers.pdf');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BankTransfer $bank_transfer)
    {
        return view('bankTransfers.show', compact('bank_transfer'));
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
