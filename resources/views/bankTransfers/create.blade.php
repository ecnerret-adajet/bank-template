@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Content Header (Page header) -->
    <div class="content-header mb-3 mt-4">
        <div class="row">
          <div class="col pt-3">
            <span class="h3 text-dark">Bank Transfer</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    {!! Form::model($bankTransfer = new \App\BankTransfer, ['url' => 'bankTransfers', 'files' => 'true', 'enctype' => 'multipart\form-data']) !!}
    {!! csrf_field() !!}
        <form>
        @include('bankTransfers.form')
        </form>
    {!! Form::close() !!} 
   
</div>
@endsection
