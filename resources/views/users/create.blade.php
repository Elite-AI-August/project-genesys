@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    @include('partials.sectionhead')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">

                        {!! Form::open(array('url' => route('users'),'files' => true)) !!}
                        @include('users/partials/_form')
                        {!! Form::submit('Create', array('class' => 'btn btn-primary')) !!}
                        {!! Form::close() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
    </section>
</div>
@stop