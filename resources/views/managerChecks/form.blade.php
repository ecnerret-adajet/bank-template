 {{-- <div class="row">

        <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Branch Manager</label>
                {!! Form::select('manager_list', $managers, null, ['placeholder' => 'Select Bank', 'class' => 'form-control'] ) !!}
                @if ($errors->has('manager_list'))
                    <div class="form-control-feedback">
                    <small class="text-danger">
                        {{ $errors->first('manager_list') }}
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

        <div class="col">
        <div class="form-group">
            <label for="driverName">Account Number</label>
            {!! Form::select('account_number', $accounts, null, ['placeholder' => 'Select Account Number', 'class' => 'form-control'] ) !!}
            @if ($errors->has('account_number'))
                    <div class="form-control-feedback">
                        <small class="text-danger">
                        {{ $errors->first('account_number') }}
                        </small>
                    </div>
                @endif
        </div>
    </div>


</div> --}}


    <!-- Table for payees -->
{{-- 
    <div class="row">
        <div class="col">  --}}
            <manager-check-form user_id="{{ Auth::user()->id }}"></manager-check-form>
        {{-- </div>
    </div> --}}


{{-- 
 <div class="row">

          <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Authorized Signatory</label>
                {!! Form::select('signatory_list', $signatories, null, ['placeholder' => 'Select Signatory', 'class' => 'form-control'] ) !!}
                @if ($errors->has('signatory_list'))
                    <div class="form-control-feedback">
                    <small class="text-danger">
                        {{ $errors->first('signatory_list') }}
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
    </div> --}}