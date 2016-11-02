@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    @include('partials.sectionhead')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body edit-user">

                        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id],'class'=>'form-horizontal','files' => true]) !!}
                        @include('users/partials/_form',compact($user))
                        {!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}
                        {!! Form::close() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>
    </section>
</div>
@stop