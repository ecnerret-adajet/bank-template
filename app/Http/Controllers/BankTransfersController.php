<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CompanyTraits;
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

     use CompanyTraits;

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
        return view('bankTransfers.create');
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
            'from_account' => 'required',
            'to_account' => 'required',
            'bank_list' => 'required',
            'signatory1' => 'required',
            // 'signatory2' => 'required',
        ]);

        $last_count = !empty(BankTransfer::first()) ? BankTransfer::orderBy('id','DESC')->first()->id : 0;
        $bank = Bank::whereId($request->input('bank_list'))->first();
        $from = Account::where('id',$request->input('from_account'))->with('company')->first();
        $to = Account::where('id',$request->input('to_account'))->with('company')->first();

        $bankTransfer = Auth::user()->bankTransfers()->create([
            'ref_num' => $from->company->abbrv.'-BT-'.sprintf('%08d', $last_count),
            'amount' => $request->input('amount'),
            'manager_id' => $bank->manager->id,
            'from_company' => $from->company->full_company,
            'to_company' => $to->company->full_company,
            'from_account' => $from->account_number,
            'to_account' => $to->account_number,
            'signatories' => [
                array('name' => $request->input('signatory1')),
                array('name' => $request->input('signatory2'))
            ]
        ]);
        $bankTransfer->manager()->associate($bank->manager->id);
        $bankTransfer->bank()->associate($bank->id);
        $bankTransfer->save();

        return ['redirect' => route('bank-transfers.show', $bankTransfer)];
    }

    /**
     * Generate PDF From Bank Transfer
     */
    public function generatePDF(BankTransfer $x)
    {
        // enable extension=php_intl.dll from PHP.INI to user NumberFormatter -> windows
        // Delete all content form /storage/fonts directory -> linux

        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $img = $this->findCompanyAvatar($x->from_company);

        $pdf = PDF::loadView('bankTransfers.pdf', compact('x','f','img'));
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
