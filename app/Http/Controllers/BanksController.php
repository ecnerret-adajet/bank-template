<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Bank;
use Carbon\Carbon;
use App\Manager;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::all();
        return view('banks.index', compact('banks'));
    }

    /**
     * Get JSON bank
     */
    public function getBank()
    {
        $banks = Bank::with('manager','accounts')->get();
        return $banks;
    }

    /**
     * Return banks with assigned accounts only
     *
     * @return json
     */
    public function getBankWithAccounts()
    {
        $banks = Bank::has('accounts')
                ->with('manager','accounts')
                ->get();

        return $banks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banks.create');
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
            'branch' => 'required|string|unique:banks',
            'location' => 'required'
        ]);

        $bank = Auth::user()->banks()->create($request->all());
        return $bank;
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
    public function update(Request $request, Bank $bank)
    {
         $this->validate($request, [
            'name' => 'required',
            'branch' => 'required|string|unique:banks,branch,'.$bank->id,
            'location' => 'required'
        ]);

        $bank->update($request->all());
        return $bank;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return response()->json($bank, 200);
    }
}
