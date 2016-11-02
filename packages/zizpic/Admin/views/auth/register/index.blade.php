@extends('maintenance::layouts.public')

@section('title', 'Register')

@section('content')

    <div class="login-box">

        <div class="login-logo">Register</div>

        {!!
            Form::open([
                'url' => route('maintenance.register'),
            ])
        !!}

        <div class="login-box-body">

            <div class="form-group">
                {!! Form::text('first_name', null, ['class'=>'form-control', 'placeholder'=>'First Name']) !!}
                <span class="label label-danger">{{ $errors->first('first_name') }}</span>
            </div>
            <div class="form-group">
                {!! Form::text('last_name', null, ['class'=>'form-control', 'placeholder'=>'Last Name']) !!}
                <span class="label label-danger">{{ $errors->first('last_name') }}</span>
            </div>
            <div class="form-group">
                {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Email Address']) !!}
                <span class="label label-danger">{{ $errors->first('email') }}</span>
            </div>
            <div class="form-group">
                {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) !!}
                <span class="label label-danger">{{ $errors->first('password') }}</span>
            </div>
            <div class="form-group">
                {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Confirm Password']) !!}
                <span class="label label-danger">{{ $errors->first('password_confirmation') }}</span>
            </div>

            <div class="form-group">
                {!! Form::captcha() !!}
                <span class="label label-danger">{{ $errors->first('g-recaptcha-response') }}</span>
            </div>

            <div class="clearfix"></div>

            <p class="text-center">
                <a href="{{ route('maintenance.login') }}" class="text-center">I already have an account</a>
            </p>

        </div>

        <div class="footer">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>

        {!! Form::close() !!}

    </div>

    {!! Captcha::script() !!}
@stop
