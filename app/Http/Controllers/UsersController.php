<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
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
     * User's JSON display
     */
    public function getUsers()
    {
        $users = User::with('roles')->get();
        return $users;
    }

    /**
     * Get all Roles
     */
    public function getRoles()
    {
        $roles = Role::with('permissions')->get();
        return $roles;
    }

    /**
     * Get all Permission
     */
    public function getPermissions()
    {
        $permissions = Permission::with('roles')->get();
        return $permissions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user->with('roles')->first();
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
    public function update(Request $request, User $user)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role_list' => 'required',
        ]);
        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if(!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }
        if(!empty($request->input('permission_list'))) {
            $user->attachPermission($request->input('permission_list'));
        }
        $user->attachRole($request->input('role_list'));
        $user->save();

        return [
            'redirect' => route('users.index')
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
