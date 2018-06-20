@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Content Header (Page header) -->
    <div class="content-header mb-3 mt-4">
        <div class="row">
          <div class="col pt-3">
            <span class="h3 text-dark">Create Template</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>

    {!! Form::model($form = new \App\Form, ['url' => 'forms', 'files' => 'true', 'enctype' => 'multipart\form-data']) !!}
    {!! csrf_field() !!}
        <form>
        @include('forms.form')
        </form>
    {!! Form::close() !!} 
   
</div>
@endsection
