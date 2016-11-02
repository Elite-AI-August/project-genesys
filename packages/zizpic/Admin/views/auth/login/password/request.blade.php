@extends('maintenance::layouts.public')

@section('content')
    <div class="login-box">

        <div class="login-logo">{{ $title }}</div>

        {!!
            Form::open([
                'url' => route('maintenance.login.forgot-password'),
                'class' => 'ajax-form-post',
                'data-status-target' => '#forgot-password-status',
            ])
        !!}

        <div class="login-box-body">
            <div id="forgot-password-status"></div>

            <div class="form-group has-feedback">
                {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=> 'Email / Username']) !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            {{ link_to_route('maintenance.login', 'Go Back to Login') }}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
        </div>

        {!! Form::close() !!}
    </div>
@stop
