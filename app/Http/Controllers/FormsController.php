<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use Carbon\Carbon;
use App\Bank;
use App\Company;
use PDF;

class FormsController extends Controller
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
        $banks = Bank::pluck('name','id');
        $companies = Company::pluck('name','id');

        return view('forms.create', compact('banks','companies'));
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
            'bank_list' => 'required',
            'company_list' => 'required',
            'field1' => 'required'
        ]);

        $form = new Form;
        $form->user_id = 1;
        $form->bank()->associate($request->input('bank_list'));
        $form->company()->associate($request->input('company_list'));
        $form->field1 = $request->input('field1');
        $form->remarks = $request->input('remarks');
        $form->save();

        return redirect('forms/'.$form->id);
    }

    /**
     * Generate PDF from stored form template
     */
    public function generatePDF(Form $form)
    {
        $pdf = PDF::loadView('forms.pdf', compact('form'));
        return $pdf->stream('forms.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        return view('forms.show', compact('form'));
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
