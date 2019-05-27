<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\Company;
use App\Bank;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::orderBy('id','desc')->get();
        return AccountResource::collection($accounts);
    }

    /**
     * Show all account - with company
     */
    public function getAccounts()
    {
        $accounts = Account::orderBy('id','desc')->get();

        return $accounts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::pluck('branch','id');
        $companies = Company::get()->pluck('full_company','id');
        return view('accounts.create',compact('banks','companies'));
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
            'account_number' => 'required|unique:accounts',
            'bank_list' => 'required',
            'company_list' => 'required'
        ]);

        $account = Auth::user()->accounts()->create([
            'account_number' => $request->input('account_number')
        ]);
        $account->bank()->associate($request->input('bank_list'));
        $account->company()->associate($request->input('company_list'));
        $account->save();

        return new AccountResource($account);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, Account $account)
    {
        $this->validate($request, [
            'account_number' => 'required|unique:accounts,account_number,'.$account->id,
            'bank_list' => 'required',
            'company_list' => 'required'
        ]);

        $account->account_number = $request->input('account_number');
        $account->bank()->associate($request->input('bank_list'));
        $account->company()->associate($request->input('company_list'));
        $account->save();

        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return response()->json($account, 200);
    }
}
