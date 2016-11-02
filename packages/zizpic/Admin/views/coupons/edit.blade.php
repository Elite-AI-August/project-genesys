@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    @include('partials.sectionhead')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        {!! Form::model($zizpicCoupons, ['method' => 'PATCH', 'route' => ['coupons.update', $zizpicCoupons->id],'class'=>'form-horizontal']) !!}
                        @include('packages::coupons.form', compact('zizpicCoupons'))
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
    </section>
</div>
@stop


