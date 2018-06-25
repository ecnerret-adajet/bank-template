 <div class="row">

        <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Branch Manager</label>
                {!! Form::select('manager_list', $managers, null, ['placeholder' => 'Select Manager', 'class' => 'form-control'] ) !!}
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

    <!-- Table for payees -->

    <div class="row">
        <div class="col"> 
            <payroll-form-table user_id="{{ Auth::user()->id }}"></payroll-form-table>
        </div>
    </div>



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
    </div>