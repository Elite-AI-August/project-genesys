@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    @include('partials.sectionhead')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id],'class'=>'form-horizontal']) !!}
                        @include('roles.form', compact('role'))
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
    </section>
</div>
@stop


