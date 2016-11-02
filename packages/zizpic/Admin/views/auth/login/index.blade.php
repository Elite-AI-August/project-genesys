@extends('maintenance::layouts.public')

@section('title', 'Login')

@section('content')

    <div class="login-box">

        <div class="login-logo">Login</div>

        {!!
            Form::open([
                'url' => route('maintenance.login'),
                'id' => 'maintenance-login'
            ])
        !!}

        <div class="login-box-body">

            <div id="maintenance-login-status"></div>

            <div class="form-group{{ $errors->first('email', ' has-error') }}">
                {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email / Username')) !!}

                <span class="label label-danger">{{ $errors->first('email', ':message') }}</span>
            </div>

            <div class="form-group{{ $errors->first('password', ' has-error') }}">
                {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) !!}

                <span class="label label-danger">{{ $errors->first('password', ':message') }}</span>
            </div>

            <div class="form-group">
                {!! Form::checkbox('remember', 'true') !!} Remember me
            </div>

                <p class="text-center">
                    {!! link_to_route('maintenance.login.forgot-password', 'Forgot Password?') !!}
                </p>

                <p class="text-center">
                    {!! link_to_route('maintenance.register', "Don't Have an Account?") !!}
                </p>

        </div>

        <div class="form-group">
            <button id="btn-sign-in" type="submit" class="btn btn-primary btn-block btn-flat">Sign in</button>
        </div>

        {!! Form::close() !!}
    </div>

@stop
