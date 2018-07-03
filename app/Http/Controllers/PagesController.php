<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use Carbon\Carbon;
use App\User;
use App\BankTransfer;
use App\ManagerCheck;
use App\Payroll;

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

    /**
     * Submitted Forms
     */
    public function submittedForms()
    {
        return view('submitted-forms');
    }

    public function submittedBankTransfer($date)
    {
        $checkDate = !empty($date) ? Carbon::parse($date) : Carbon::today();

        $submitted = BankTransfer::whereDate('created_at',$checkDate)->currentUser();
        
        return $submitted;
    }

    public function submittedManagerCheck($date)
    {
        $checkDate = !empty($date) ? Carbon::parse($date) : Carbon::today();

        $submitted = ManagerCheck::whereDate('created_at',$checkDate)->currentUser();
        
        return $submitted;
    }

    public function submittedPayroll($date)
    {
        $checkDate = !empty($date) ? Carbon::parse($date) : Carbon::today();

        $submitted = Payroll::whereDate('created_at',$checkDate)->currentUser();

        return $submitted;
    }

    /**
     * Master Data Page
     */
    public function masterData()
    {
        return view('master-data');
    }
}
