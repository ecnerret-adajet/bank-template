@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Content Header (Page header) -->
    <div class="content-header mb-3 mt-4">
        <div class="row">
          <div class="col pt-3">
            <span class="h3 text-dark">Manager's Check</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    {!! Form::model($manager_check = new \App\ManagerCheck, ['url' => 'manager-checks', 'files' => 'true', 'enctype' => 'multipart\form-data']) !!}
    {!! csrf_field() !!}
        <form>
        @include('managerChecks.form')
        </form>
    {!! Form::close() !!} 
   
</div>
@endsection
