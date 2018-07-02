<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use App\User;

class PagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Get recent submitted
     */
    public function recentSubmitted()
    {
        $recentSubmitted = User::where('id',Auth::user()->id)
                ->with('recentBanktransfer','recentManagerChecks','recentPayrolls')
                ->first();

        return $recentSubmitted;
    }

    public function masterData()
    {
        return view('master-data');
    }
}
