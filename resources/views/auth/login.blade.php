@extends('layouts.full')

@section('content')
<div class="container">

    <div class="container d-flex h-100 mt-5">
    <div class="row align-self-center w-100">
        <div class="col-8 mx-auto">
            <div class="jumbotron bg-dark">

                <h1 class="text-center text-white">Bank Template</h1>
                <p class="lead text-center">La Filipina Uy Gongco Group of Companies</p>

                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">


                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="form-row control-label">E-Mail Address</label>
                            <div class="form-row">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="form-row control-label">Password</label>

                            <div class="form-row">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <div class="col">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>
                            </div>
                        </div>

                        <div class="form-row text-center">
                              <div class="col">
                            <a class="btn btn-link text-white" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                        </div>

                       

                    
                    </div>
                </div>
                </form>

                
            </div>
        </div>
    </div>
</div>
</div>
@endsection
