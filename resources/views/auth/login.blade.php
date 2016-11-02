@extends('app')

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="login-box">
    <div class="login-logo">
        <a href="{{url('/')}}">
            {!! Config::get( 'app.app_name' )  !!}
        </a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        @if (Session::has('flash_alert_notice'))
        <div class="alert alert-danger">{{ Session::get('flash_alert_notice') }}</div>
        @endif
        <p class="login-box-msg">Sign in to start your session</p>
        <form class="form-horizontal" role="form" method="POST" action="{{ url($locale.'/login') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group has-feedback">
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
        </form>

        <!--<a class="btn btn-link" href="{{ url('/password/email') }}">I forgot my password</a><br>-->
    </div>
</div>
</div>
</div>
</div>
</div>

@endsection
