 <div class="row">

        <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Banks</label>
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
                <label for="exampleSelect2">Companies</label>
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

         <div class="col">
            <div class="form-group {{ $errors->has('field1') ? ' has-danger' : '' }}">
                <label for="driverName">Account Number</label>
                {{ Form::text('field1', null, ['class' => 'form-control', 'placeholder' => 'Enter Account Number']) }}
                <small id="accoutNumber" class="form-text text-muted">We'll never share your email with anyone else.</small>
                @if ($errors->has('field1'))
                        <div class="form-control-feedback">
                            <small class="text-danger">
                            {{ $errors->first('field1') }}
                            </small>
                        </div>
                    @endif
            </div>
        </div>


    </div>

    <div class="row mt-3">
        <div class="col">

     <div class="form-group {{ $errors->has('remarks') ? ' has-danger' : '' }}">
      <label for="exampleTextarea">Remarks</label>
        {{ Form::textarea('remarks', null, ['class' => 'form-control', 'placeholder' => 'Enter Remarks','rows' => '3']) }}      @if ($errors->has('remarks'))
            <div class="form-control-feedback">
                <small class="text-danger">
                {{ $errors->first('remarks') }}
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