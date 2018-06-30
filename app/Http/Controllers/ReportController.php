<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illumniate\Support\Facades\Auth;
use Carbon\Carbon;
use App\ManagerCheck;
use App\BankTransfer;
use App\Payroll;
use App\Manager;
use App\Company;
use App\Bank;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function getBankTransfer($date)
    {
        $checkDate = !empty($date) ? Carbon::parse($date) : Carbon::today();

        $bankTransfer = BankTransfer::whereDate('created_at',$checkDate)
                        ->with('manager','bank','user')
                        ->get();

        return $bankTransfer;
    }

    public function getManagerCheck($date)
    {
        $checkDate = !empty($date) ? Carbon::parse($date) : Carbon::today();

        $managerCheck = ManagerCheck::whereDate('create_at')->get();

        return $managerCheck;
    }

    public function getPayroll($date)
    {
        $checkDate = !empty($date) ? Carbon::parse($date) : Carbon::today();

        $payrolls = Payroll::whereDate('create_at')->get();

        return $payrolls;
    }
    
}
