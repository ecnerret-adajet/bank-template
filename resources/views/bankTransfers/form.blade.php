


<bank-transfer-form></bank-transfer-form>

 {{-- <div class="row">

    <div class="col">
            <div class="form-group">
            <label for="exampleSelect2">From Company</label>
            {!! Form::select('from_company', $companies, null, ['placeholder' => 'Select Company', 'class' => 'form-control'] ) !!}
            @if ($errors->has('from_company'))
                <div class="form-control-feedback">
                <small class="text-danger">
                    {{ $errors->first('from_company') }}
                    </small>
                </div>
            @endif
        </div>
    </div>

        <div class="col">
        <div class="form-group">
            <label for="driverName">From Account Number</label>
            {!! Form::select('from_account', $accounts, null, ['placeholder' => 'Select Account Number', 'class' => 'form-control'] ) !!}
            @if ($errors->has('from_account'))
                    <div class="form-control-feedback">
                        <small class="text-danger">
                        {{ $errors->first('from_account') }}
                        </small>
                    </div>
                @endif
        </div>
    </div>


</div> --}}


{{-- <div class="row">

    <div class="col">
            <div class="form-group">
            <label for="exampleSelect2">To Company</label>
            {!! Form::select('to_company', $companies, null, ['placeholder' => 'Select Company', 'class' => 'form-control'] ) !!}
            @if ($errors->has('to_company'))
                <div class="form-control-feedback">
                <small class="text-danger">
                    {{ $errors->first('to_company') }}
                    </small>
                </div>
            @endif
        </div>
    </div>

        <div class="col">
        <div class="form-group">
            <label for="driverName">To Account Number</label>
            {!! Form::select('to_account', $accounts, null, ['placeholder' => 'Select Account Number', 'class' => 'form-control'] ) !!}
            @if ($errors->has('to_account'))
                    <div class="form-control-feedback">
                        <small class="text-danger">
                        {{ $errors->first('to_account') }}
                        </small>
                    </div>
                @endif
        </div>
    </div>


</div> --}}

 {{-- <div class="row">

        <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Amount</label>
                {{ Form::text('amount', null, ['class' => 'form-control', 'placeholder' => 'Enter Amount']) }}
                @if ($errors->has('amount'))
                    <div class="form-control-feedback">
                    <small class="text-danger">
                        {{ $errors->first('amount') }}
                        </small>
                    </div>
                @endif
            </div>
        </div>

          <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Authorized Signatory</label>
                {!! Form::select('signatory_list', $signatories, null, ['placeholder' => 'Select Signatory', 'class' => 'form-control signatories', 'multiple'] ) !!}
                @if ($errors->has('signatory_list'))
                    <div class="form-control-feedback">
                    <small class="text-danger">
                        {{ $errors->first('signatory_list') }}
                        </small>
                    </div>
                @endif
            </div>
        </div>

 </div> --}}




    <div class="row mt-3">
        <div class="col">
            <button type="submit" class="btn btn-primary btn-block">Publish</button>
        </div>
    </div>