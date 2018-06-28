 <div class="row">

        <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Bank</label>
                {!! Form::select('bank_list', $banks, null, ['placeholder' => 'Select Bank', 'class' => 'form-control'] ) !!}
                @if ($errors->has('bank_list'))
                    <div class="form-control-feedback">
                    <small class="text-danger">
                        {{ $errors->first('bank_list') }}
                        </small>
                    </div>
                @endif
            </div>
        </div>

        <div class="col">
             <div class="form-group">
                <label>Account Nuber</label>
                {{ Form::text('account_number', null, ['class' => 'form-control acc_format', 'placeholder' => 'Enter account_number']) }}
                @if ($errors->has('account_number'))
                    <div class="form-control-feedback">
                    <small class="text-danger">
                        {{ $errors->first('account_number') }}
                        </small>
                    </div>
                @endif
            </div>
        </div>

 </div>

 <div class="row">

        <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Company</label>
                {!! Form::select('company_list', $companies, null, ['placeholder' => 'Select Company', 'class' => 'form-control'] ) !!}
                @if ($errors->has('company_list'))
                    <div class="form-control-feedback">
                    <small class="text-danger">
                        {{ $errors->first('company_list') }}
                        </small>
                    </div>
                @endif
            </div>
        </div>

 </div>




    <div class="row mt-3">
        <div class="col">
            <button type="submit" class="btn btn-primary btn-block">Publish</button>
        </div>
    </div>

@section('script')

<script>

     $('.acc_format').inputmask("9999 9999 99",{ placeholder: "" });

</script>

@endsection