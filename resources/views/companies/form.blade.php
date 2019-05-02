<div class="row">
    <div class="col">
            <div class="form-group">
            <label for="exampleSelect2">Company Name</label>
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Company Name']) }}
            @if ($errors->has('name'))
                <div class="form-control-feedback">
                    <small class="text-danger">
                        {{ $errors->first('name') }}
                    </small>
                </div>
            @endif
        </div>
    </div>
 </div>

  <div class="row">
        <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Division</label>
                {{ Form::text('department', null, ['class' => 'form-control', 'placeholder' => 'Enter Division']) }}
                @if ($errors->has('department'))
                    <div class="form-control-feedback">
                        <small class="text-danger">
                            {{ $errors->first('department') }}
                        </small>
                    </div>
                @endif
            </div>
        </div>
        <div class="col">
             <div class="form-group">
                <label for="exampleSelect2">Abbreviation</label>
                {{ Form::text('abbrv', null, ['class' => 'form-control', 'placeholder' => 'Enter Abbreviation']) }}
                @if ($errors->has('abbrv'))
                    <div class="form-control-feedback">
                        <small class="text-danger">
                            {{ $errors->first('abbrv') }}
                        </small>
                    </div>
                @endif
            </div>
        </div>
 </div>

  <div class="content-header mb-3 mt-2">
        <div class="row">
          <div class="col pt-3">
            <span class="h3 text-dark">Assign Signatories</span>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>



    <div class="row mt-3">
        <div class="col">
            <button type="submit" class="btn btn-primary btn-block">Publish</button>
        </div>
    </div>
