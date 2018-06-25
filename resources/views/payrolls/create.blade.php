@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Content Header (Page header) -->
    <div class="content-header mb-3 mt-4">
        <div class="row">
          <div class="col pt-3">
            <span class="h3 text-dark">Payroll Application</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    {!! Form::model($payroll = new \App\Payroll, ['url' => 'payrolls', 'files' => 'true', 'enctype' => 'multipart\form-data']) !!}
    {!! csrf_field() !!}
        <form>
        @include('payrolls.form')
        </form>
    {!! Form::close() !!} 
   
</div>
@endsection
