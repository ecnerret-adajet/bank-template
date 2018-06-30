@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Content Header (Page header) -->
    <div class="content-header mb-3 mt-4">
        <div class="row">
          <div class="col pt-3">
            <span class="h3 text-dark">All Forms</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    <div class="row">
        <div class="col">
            <div class="card border-primary mb-3">
            
            <div class="card-body text-center">
            
                <img src="{{ asset('/fonts/flat/transfer-money.svg') }}" style="height: 100px; width:auto" alt="bank_transfer">

                <h4 class="card-title mt-4">Bank Transfer</h4>
            </div>
                <div class="card-footer">
                <a href="{{ url('/bank-transfers/create') }}">
                    Create Now
                </a>
                    
                </div>
            </div>

        </div>
        <div class="col">

               <div class="card border-primary mb-3">
            
            <div class="card-body text-center">
            
                <img src="{{ asset('/fonts/flat/writing-cheque.svg') }}" style="height: 100px; width:auto" alt="bank_transfer">

                <h4 class="card-title mt-4">Manager's Check</h4>
            </div>
                <div class="card-footer">
                <a href="{{ url('/manager-checks/create') }}">
                    Create Now
                </a>
                    
                </div>
            </div>

        </div>
        <div class="col">

               <div class="card border-primary mb-3">
            
            <div class="card-body text-center">
            
                <img src="{{ asset('/fonts/flat/atm.svg') }}" style="height: 100px; width:auto" alt="bank_transfer">

                <h4 class="card-title mt-4">Payroll Application</h4>
            </div>
                <div class="card-footer">
                <a href="{{ url('/payrolls/create') }}">
                    Create Now
                </a>
                    
                </div>
            </div>

        </div>
    </div>

     <div class="content-header mb-3 mt-4">
        <div class="row">
          <div class="col pt-3">
            <span class="h3 text-dark">Recently Submitted</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    <div class="row">
        <div class="col">
            {{-- {{ $recentSubmitted }} --}}
        </div>
    </div>


</div>
@endsection
