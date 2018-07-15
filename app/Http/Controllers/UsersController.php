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
        $roles = Role::orderBy('id','desc')->with('permissions')->get();
        return $roles;
    }

    /**
     * Get all Permission
     */
    public function getPermissions()
    {
        $permissions = Permission::orderBy('id','desc')->get();
        return $permissions;
    }

    /**
     * Store Permissions
     * 
     */
    public function storePermission(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
        ]);

        $permission = Permission::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description')
        ]);

        return $permission;
    }

    /**
     * Store Roles
     */
    public function storeRoles(Request $request) 
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'level' => $request->input('level'),
        ]);

        return $role;
    }

    /**
     * Update Roles
     */
    public function updateRoles(Request $request, Role $role) 
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->level = $request->input('level');

        if(!empty($request->input('attach_list'))) {
            $role->syncPermissions($request->input('attach_list'));
        }
        
        if(!empty($request->input('detach_list'))) {
            $detaches = $request->input('detach_list');
            foreach($detaches as $d) {
                $role->detachPermission($d);
            }        
        }
        
        $role->save();

        return $role->with('permissions')->get();
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
        return $user->with('roles','userPermissions')->first();
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
        
        if(!empty($request->input('attach_perm'))) {
            $user->syncPermissions($request->input('attach_perm'));
        }
        
        if(!empty($request->input('detach_perm'))) {
            $detaches = $request->input('detach_perm');
            foreach($detaches as $d) {
                $user->detachPermission($d);
            }        
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
