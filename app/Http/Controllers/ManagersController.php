<?php

namespace App\Http\Controllers;

use App\Http\Resources\ManagerResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Manager;
use App\Bank;

class ManagersController extends Controller
{
    /**
     * Display a listing of the resource. for manager.vue component [safe]
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $managers = Manager::orderBy('id','desc')->get();
         return ManagerResource::collection($managers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::pluck('name','id');
        return view('managers.create', compact('banks'));
    }

    /**
     * Display managers JSON
     */
    public function getManagers()
    {
        $managers = Manager::orderBy('id','desc')->get();
        // return ManagerResource::collection($managers);
        return $managers;
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
            'title' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'bank_list' => 'required'
        ]);

        $manager = Manager::create($request->all());
        $manager->bank()->associate($request->input('bank_list'));
        $manager->save();

        return new ManagerResource($manager);
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
    public function update(Request $request, Manager $manager)
    {
        $this->validate($request, [
            'title' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'bank_list' => 'required'
        ]);

        $manager->update($request->all());
        $manager->bank()->associate($request->input('bank_list'));
        $manager->save();

        return new ManagerResource($manager);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manager $manager)
    {
        $manager->delete();
        return response()->json($manager, 200);
    }
}
