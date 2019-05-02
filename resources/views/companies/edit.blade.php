@extends('layouts.app')

@section('content')
<div class="container">


    <company-edit companyid="{{ $company->id }}"></company-edi>

    {{-- {!! Form::model($company, ['method' => 'PATCH','route' => ['companies.update', $company->id], 'enctype'=>'multipart/form-data']) !!}
    {!! csrf_field() !!}
        <form> --}}
            {{-- @include('companies.form') --}}
        {{-- </form>
    {!! Form::close() !!} --}}

</div>
@endsection
