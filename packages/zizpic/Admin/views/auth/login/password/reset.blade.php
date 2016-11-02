@extends('maintenance::layouts.public')

@section('content')
    <div class="login-box">

        <div class="login-logo">{{ $title }}</div>

        {!!
            Form::open([
                'url' => route('maintenance.login.reset-password', [$user->id, $code]),
                'class' => 'ajax-form-post clear-form',
                'data-status-target' => '#reset-password-status',
            ])
        !!}

        <div class="login-box-body">

            <div id="reset-password-status"></div>

            <div class="form-group has-feedback">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Your New Password']) !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
        </div>

        {!! Form::close() !!}
    </div>
@stop
