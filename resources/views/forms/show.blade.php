@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Content Header (Page header) -->
    <div class="content-header mb-3 mt-4">
        <div class="row">
          <div class="col pt-3">
            <span class="h3 text-dark">Show Template</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    <div class="row">
        <div class="col">

        <a href="{{ url('forms/generate/'.$form->id) }}" target="_blank" class="btn btn-info">View PDF</a>

        </div>
    </div>
   
</div>
@endsection
