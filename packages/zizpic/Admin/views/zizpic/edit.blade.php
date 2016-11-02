@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    @include('partials.sectionhead')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        {!! Form::model($zizpicOrder, ['method' => 'PATCH', 'route' => ['zizpicorders.update', $zizpicOrder->id],'class'=>'form-horizontal']) !!}
                        @include('packages::metrics.form', compact('zizpicOrder'))
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
    </section>
</div>
@stop


